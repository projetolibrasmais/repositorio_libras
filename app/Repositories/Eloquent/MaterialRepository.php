<?php

namespace App\Repositories\Eloquent;

use App\Helpers\StorageHelper;
use App\Models\Material;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class MaterialRepository extends BaseRepository
{
    /**
     * @var Material
     */
    protected $model;

    public function __construct(Material $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records.
     */
    public function all($request = null, $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->query();

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
    public function find(int $id): ?Material
    {
        return $this->model->withTrashed()->find($id);
    }

    /**
     * Create a new record.
     */
    public function create(array $data): Material
    {
        $arquivo = $data['arquivo'] ?? null;
        unset($data['arquivo']);

        if ($arquivo) {
            $arquivoPath = StorageHelper::uploadMaterial(
                $arquivo,
                $data['titulo'],
            );

            if ($arquivoPath) {
                $data['arquivo_path'] = $arquivoPath;
                $data['tipo'] = $arquivo->getClientOriginalExtension();
                $data['tamanho'] = $this->formatBytes($arquivo->getSize());
            } else {
                throw new \Exception('Falha ao fazer upload do arquivo.');
            }
        }

        return parent::create($data);
    }

    /**
     * Update an existing record.
     */
    public function update(int $id, array $data): Material
    {
        $material = $this->find($id);

        if (!$material) {
            throw new \Exception('Material não encontrado.');
        }

        $arquivo = $data['arquivo'] ?? null;
        unset($data['arquivo']);

        if ($arquivo) {
            $arquivoPath = StorageHelper::replaceMaterial(
                $material->arquivo_path,
                $arquivo,
                $data['titulo'],
            );

            if ($arquivoPath) {
                $data['arquivo_path'] = $arquivoPath;
                $data['tipo'] = $arquivo->getClientOriginalExtension();
                $data['tamanho'] = $this->formatBytes($arquivo->getSize());
            } else {
                throw new \Exception('Falha ao fazer upload do novo arquivo.');
            }
        }

        return parent::update($id, $data);
    }

    /**
     * Delete a record.
     */
    public function delete(int $id): bool
    {
        $material = $this->find($id);

        if (!$material) {
            throw new \Exception('Material não encontrado.');
        }

        return $material->delete();
    }

    /**
     * Force delete a record.
     */
    public function forceDelete(int $id): bool
    {
        $material = $this->find($id);

        if (!$material) {
            throw new \Exception('Material não encontrado.');
        }

        // Delete the file from storage
        if ($material->arquivo_path) {
            StorageHelper::deleteMaterial($material->arquivo_path);
        }

        return $material->forceDelete();
    }

    /**
     * Restore a soft-deleted record.
     */
    public function restore(int $id): bool
    {
        $material = $this->find($id);

        if (!$material) {
            throw new \Exception('Material não encontrado.');
        }

        return $material->restore();
    }

    /**
     * Bulk delete records.
     */
    public function bulkDelete(array $ids): bool
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    /**
     * Bulk restore records.
     */
    public function bulkRestore(array $ids): bool
    {
        return $this->model->whereIn('id', $ids)->restore();
    }

    /**
     * Bulk force delete records.
     */
    public function bulkForceDelete(array $ids): bool
    {
        $materiais = $this->model->withTrashed()->whereIn('id', $ids)->get();

        foreach ($materiais as $material) {
            if ($material->arquivo_path) {
                StorageHelper::deleteMaterial($material->arquivo_path);
            }
        }

        return $this->model->withTrashed()->whereIn('id', $ids)->forceDelete();
    }

    /**
     * Format bytes to human-readable format.
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
