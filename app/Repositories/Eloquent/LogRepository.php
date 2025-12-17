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
     * Apply advanced filters to query.
     */
    protected function applyFilters($query, $request)
    {
        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('causer_id', $request->user_id);
        }

        // Filter by event
        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        // Filter by log name
        if ($request->filled('log_name')) {
            $query->where('log_name', $request->log_name);
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
     * Get all records with pagination and filters.
     */
    public function all($request = null, $perPage = 15)
    {
        $query = $this->getBaseQuery();

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
}