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
}