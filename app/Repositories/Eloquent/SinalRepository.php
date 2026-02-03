<?php

namespace App\Repositories\Eloquent;

use App\Helpers\StorageHelper;
use App\Models\Sinal;
use App\Models\Video;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class SinalRepository extends BaseRepository
{
    /**
     * @var Sinal
     */
    protected $model;

    public function __construct(Sinal $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records.
     */
    public function all($request = null, $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->query()->with(['video', 'categorias', 'imagens']);

        if ($request) {
            $query->withDeletedFilter($request->get('show_deleted'));

            if ($request->filled('search')) {
                $query->search($request->search);
            }

            $query->applyFilters($request);

            $sortColumn = $request->get('sort', 'created_at');
            $sortDirection = $request->get('direction', 'desc');
            $query->orderByColumn($sortColumn, $sortDirection);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Find a record by its ID.
     */
    public function find(int $id): ?Sinal
    {
        return $this->model->withTrashed()->with(['video' => function ($query) {
            $query->withTrashed();
        }, 'categorias', 'imagens' => function ($query) {
            $query->withTrashed();
        }])->find($id);
    }

    /**
     * Create a new record.
     */
    public function create(array $data): Sinal
    {
        $data['slug'] = Str::slug($data['palavra_portugues']);

        $categorias = $data['categorias'] ?? [];
        unset($data['categorias']);
        
        $videoFile = $data['video'] ?? null;
        unset($data['video']);

        $imagens = $data['imagens'] ?? [];
        unset($data['imagens']);


        $sinal = parent::create($data);

        if ($videoFile) {
            $videoPath = StorageHelper::uploadVideo(
                $videoFile,
                $data['palavra_portugues'],
                'sinais'
            );

            if ($videoPath) {
                Video::create([
                    'url_video' => $videoPath,
                    'sinal_id' => $sinal->id,
                ]);
            }
        }

        if ($imagens) {
            foreach ($imagens as $imagem) {
                $imagemPath = StorageHelper::uploadImage(
                    $imagem,
                    $data['palavra_portugues'],
                    'sinais'
                );

                if ($imagemPath) {
                    $sinal->imagens()->create([
                        'url_imagem' => $imagemPath,
                    ]);
                }
            }
        }

        if (!empty($categorias)) {
            $sinal->categorias()->attach($categorias);
        }

        return $sinal;
    }

    /**
     * Update a record by its ID.
     */
    public function update(int $id, array $data): ?Sinal
    {
        $data['slug'] = Str::slug($data['palavra_portugues']);

        $sinal = $this->find($id);
        if (!$sinal) {
            return null;
        }

        if (isset($data['video']) && $data['video']) {
            $oldVideo = $sinal->video;
            $oldPath = $oldVideo ? $oldVideo->url_video : null;

            $videoPath = StorageHelper::replaceVideo(
                $oldPath,
                $data['video'],
                $data['palavra_portugues'],
                'sinais'
            );

            if ($videoPath) {
                if ($oldVideo) {
                    $oldVideo->update(['url_video' => $videoPath]);
                } else {
                    Video::create([
                        'url_video' => $videoPath,
                        'sinal_id' => $sinal->id,
                    ]);
                }
            }

            unset($data['video']);
        }

        $imagens = $data['imagens'] ?? null;
        unset($data['imagens']);

        if ($imagens) {
            foreach ($imagens as $imagem) {
                $imagemPath = StorageHelper::uploadImage(
                    $imagem,
                    $data['palavra_portugues'],
                    'sinais'
                );

                if ($imagemPath) {
                    $sinal->imagens()->create([
                        'url_imagem' => $imagemPath,
                    ]);
                }
            }
        }

        $categorias = $data['categorias'] ?? null;
        unset($data['categorias']);

        $updated = parent::update($id, $data);

        if ($updated && $categorias !== null) {
            $updated->categorias()->sync($categorias);
        }

        return $updated;
    }

    /**
     * Delete a record by its ID.
     */
    public function delete(int $id): bool
    {
        $sinal = $this->find($id);
        
        if (!$sinal) {
            return false;
        }

        // Soft delete video
        if ($sinal->video) {
            $sinal->video->delete();
        }

        // Soft delete images
        if ($sinal->imagens) {
            foreach ($sinal->imagens as $imagem) {
                $imagem->delete();
            }
        }

        return $sinal->delete();
    }

    /**
     * Restore a record.
     */
    public function restore(int $id): bool
    {
        $sinal = $this->model->withTrashed()->find($id);
        
        if (!$sinal || !$sinal->trashed()) {
            return false;
        }

        $restored = $sinal->restore();
        
        if ($restored) {
            // Restore video
            $video = Video::withTrashed()->where('sinal_id', $sinal->id)->first();
            if ($video && $video->trashed()) {
                $video->restore();
            }

            // Restore images
            $imagens = $sinal->imagens()->withTrashed()->get();
            foreach ($imagens as $imagem) {
                if ($imagem->trashed()) {
                    $imagem->restore();
                }
            }
        }

        return $restored;
    }

    /**
     * Force delete a record.
     */
    public function forceDelete(int $id): bool
    {
        $sinal = $this->model->withTrashed()->find($id);
        
        if (!$sinal) {
            return false;
        }

        // Detach categories
        $sinal->categorias()->detach();

        // Delete video and file
        $video = Video::withTrashed()->where('sinal_id', $sinal->id)->first();
        if ($video) {
            if ($video->url_video) {
                StorageHelper::deleteVideo($video->url_video);
            }
            
            $video->forceDelete();
        }

        // Delete images and files
        $imagens = $sinal->imagens()->withTrashed()->get();
        foreach ($imagens as $imagem) {
            if ($imagem->url_imagem) {
                StorageHelper::deleteImage($imagem->url_imagem);
            }
            $imagem->forceDelete();
        }

        return $sinal->forceDelete();
    }

    /**
     * Delete a specific image from a sinal.
     *
     * @param int $sinalId
     * @param int $imagemId
     * @return bool
     */
    public function deleteImage(int $sinalId, int $imagemId): bool
    {
        $sinal = $this->find($sinalId);
        
        if (!$sinal) {
            return false;
        }

        $imagem = $sinal->imagens()->find($imagemId);
        
        if (!$imagem) {
            return false;
        }

        return $imagem->delete();
    }

    /**
     * Force delete a specific image from a sinal.
     *
     * @param int $sinalId
     * @param int $imagemId
     * @return bool
     */
    public function forceDeleteImage(int $sinalId, int $imagemId): bool
    {
        $sinal = $this->find($sinalId);
        
        if (!$sinal) {
            return false;
        }

        $imagem = $sinal->imagens()->withTrashed()->find($imagemId);
        
        if (!$imagem) {
            return false;
        }

        if ($imagem->url_imagem) {
            StorageHelper::deleteImage($imagem->url_imagem);
        }

        return $imagem->forceDelete();
    }
}
