<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Eloquent\BaseRepository;

class RoleRepository extends BaseRepository
{
    /**
     * @var Role
     */
    protected $model;

    public function __construct(Role $model)
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
    public function find(int $id): ?Role
    {
        return parent::find($id);
    }

    /**
     * Create a new record.
     */
    public function create(array $data): Role
    {
        $role = parent::create($data);
        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }
        return $role;
    }

    /**
     * Update a record by its ID.
     */
    public function update(int $id, array $data): ?Role
    {
        if (isset($data['permissions'])) {
            $role = $this->find($id);
            if ($role) {
                $role->syncPermissions($data['permissions']);
            }
        }
        return parent::update($id, $data);
    }

    /**
     * Delete a record by its ID.
     */
    public function delete(int $id): bool
    {
        $role = $this->find($id);

        if ($role && $role->id === 1) {
            return false; // Prevent deletion of the default role
        }

        if ($role->users()->count() > 0) {
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