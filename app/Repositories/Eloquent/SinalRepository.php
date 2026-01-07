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
        $query = $this->model->query()->with(['video', 'categorias']);

        if ($request) {
            // Apply search
            if ($request->filled('search')) {
                $query->search($request->search);
            }

            // Apply filters
            $query = $this->applyFilters($query, $request);

            // Apply sorting
            $sortColumn = $request->get('sort', 'created_at');
            $sortDirection = $request->get('direction', 'desc');
            $query->orderByColumn($sortColumn, $sortDirection);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Apply advanced filters to query.
     */
    protected function applyFilters($query, $request)
    {
        // Filter by categoria
        if ($request->filled('categoria_id')) {
            $query->whereHas('categorias', function($q) use ($request) {
                $q->where('categorias.id', $request->categoria_id);
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return $query;
    }

    /**
     * Find a record by its ID.
     */
    public function find(int $id): ?Sinal
    {
        return $this->model->with(['video', 'categorias'])->find($id);
    }

    /**
     * Create a new record.
     */
    public function create(array $data): Sinal
    {
        $data['slug'] = Str::slug($data['palavra_portugues']);

        $videoId = null;
        if (isset($data['video']) && $data['video']) {
            $videoPath = StorageHelper::uploadVideo(
                $data['video'],
                $data['palavra_portugues'],
                'sinais'
            );

            if ($videoPath) {
                $video = Video::create([
                    'url_video' => $videoPath,
                ]);

                $videoId = $video->id;
            }

            unset($data['video']);
        }

        if ($videoId) {
            $data['video_id'] = $videoId;
        }

        $categorias = $data['categorias'] ?? [];
        unset($data['categorias']);

        $sinal = parent::create($data);

        if ($videoId) {
            Video::where('id', $videoId)->update(['sinal_id' => $sinal->id]);
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
                    $video = Video::create([
                        'url_video' => $videoPath,
                        'sinal_id' => $sinal->id,
                    ]);
                    $data['video_id'] = $video->id;
                }
            }

            unset($data['video']);
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
        
        if ($sinal) {
            $video = $sinal->video;
            
            if ($video) {
                if ($video->url_video) {
                    StorageHelper::deleteVideo($video->url_video);
                }
                
                $video->delete();
            }
        }

        return parent::delete($id);
    }

    /**
     * Restore a record.
     */
    public function restore(int $id): bool
    {
        return parent::restore($id);
    }

    /**
     * Force delete a record.
     */
    public function forceDelete(int $id): bool
    {
        return parent::forceDelete($id);
    }
}
