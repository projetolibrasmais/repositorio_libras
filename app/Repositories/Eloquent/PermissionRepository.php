<?php

namespace App\Repositories\Eloquent;

use App\Models\Permission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Eloquent\BaseRepository;

class PermissionRepository extends BaseRepository
{
    /**
     * @var Permission
     */
    protected $model;

    public function __construct(Permission $model)
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
    public function find(int $id): ?Permission
    {
        return parent::find($id);
    }

    /**
     * Create a new record.
     */
    public function create(array $data): Permission
    {
        return parent::create($data);
    }

    /**
     * Update a record by its ID.
     */
    public function update(int $id, array $data): ?Permission
    {
        return parent::update($id, $data);
    }

    /**
     * Delete a record by its ID.
     */
    public function delete(int $id): bool
    {
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