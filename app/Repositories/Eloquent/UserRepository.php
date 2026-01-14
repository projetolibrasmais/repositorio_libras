<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * @var User
     */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records.
     */
    public function all($request = null, $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->query()->with('roles');

        if ($request) {
            if ($request->filled('search')) {
                $query->search($request->search);
            }

            if ($request->filled('role')) {
                $query->whereHas('roles', function($q) use ($request) {
                    $q->where('name', $request->role);
                });
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
    public function find(int $id): ?User
    {
        return parent::find($id);
    }

    /**
     * Create a new record.
     */
    public function create(array $data): User
    {
        $user = parent::create($data);
        $user->assignRole($data['role']);
        return $user;
    }

    /**
     * Update a record by its ID.
     */
    public function update(int $id, array $data): ?User
    {
        $user = parent::update($id, $data);
        if ($user && isset($data['role'])) {
            $user->syncRoles($data['role']);
        }
        return $user;
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