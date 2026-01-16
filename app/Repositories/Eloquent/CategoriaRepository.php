<?php

namespace App\Repositories\Eloquent;

use App\Models\Categoria;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class CategoriaRepository extends BaseRepository
{
    /**
     * @var Categoria
     */
    protected $model;

    public function __construct(Categoria $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records.
     */
    public function all($request = null, $perPage = 15): LengthAwarePaginator
    {
        return parent::all($request, $perPage);
    }

    /**
     * Find a record by its ID.
     */
    public function find(int $id): ?Categoria
    {
        return parent::find($id);
    }

    /**
     * Create a new record.
     */
    public function create(array $data): Categoria
    {
        $data['slug'] = Str::slug($data['nome']);

        return parent::create($data);

    }

    /**
     * Update a record by its ID.
     */
    public function update(int $id, array $data): ?Categoria
    {
        $data['slug'] = Str::slug($data['nome']);

        return parent::update($id, $data);
    }

    /**
     * Delete a record by its ID.
     */
    public function delete(int $id): bool
    {
        $categoria = $this->find($id);
        
        if ($categoria->sinais()->count() > 0) {
            return false;
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
