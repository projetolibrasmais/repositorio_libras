<?php

namespace App\Repositories\Eloquent;

use App\Models\ActivityLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Eloquent\BaseRepository;

class LogRepository extends BaseRepository
{
    /**
     * @var ActivityLog
     */
    protected $model;

    public function __construct(ActivityLog $model)
    {
        $this->model = $model;
    }

    /**
     * Get the base query builder with eager loading.
     */
    protected function getBaseQuery()
    {
        return $this->model->query()->with(['user']);
    }

    /**
     * Find a record by its ID.
     */
    public function find(int $id): ?ActivityLog
    {
        return $this->model->with(['user'])->findOrFail($id);
    }

    /**
     * Get all records with pagination and filters.
     */
    public function all($request = null, $perPage = 15)
    {
        $query = $this->getBaseQuery();

        if ($request) {
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
}