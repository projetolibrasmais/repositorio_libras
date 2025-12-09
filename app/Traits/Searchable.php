<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Scope a query to search across specified columns.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $search
     * @param array|null $columns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, ?string $search, ?array $columns = null): Builder
    {
        if (empty($search)) {
            return $query;
        }

        // Use searchable columns defined in the model or default to ['name']
        $searchableColumns = $columns ?? $this->searchable ?? ['name'];

        return $query->where(function (Builder $query) use ($search, $searchableColumns) {
            foreach ($searchableColumns as $column) {
                // Check if column contains a relation (e.g., 'user.name')
                if (str_contains($column, '.')) {
                    $this->addRelationSearch($query, $column, $search);
                } else {
                    $query->orWhere($column, 'LIKE', "%{$search}%");
                }
            }
        });
    }

    /**
     * Add search condition for related columns.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param string $search
     * @return void
     */
    protected function addRelationSearch(Builder $query, string $column, string $search): void
    {
        $parts = explode('.', $column);
        $relation = $parts[0];
        $relatedColumn = $parts[1];

        $query->orWhereHas($relation, function (Builder $query) use ($relatedColumn, $search) {
            $query->where($relatedColumn, 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope a query to search with pagination.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $search
     * @param int $perPage
     * @param array|null $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function scopeSearchAndPaginate(Builder $query, ?string $search, int $perPage = 15, ?array $columns = null)
    {
        return $query->search($search, $columns)->paginate($perPage)->withQueryString();
    }

    /**
     * Scope to apply filters dynamically.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        foreach ($filters as $key => $value) {
            if (empty($value)) {
                continue;
            }

            // Skip search parameter as it's handled separately
            if ($key === 'search') {
                continue;
            }

            // Handle exact match
            if (is_array($value)) {
                $query->whereIn($key, $value);
            } else {
                $query->where($key, $value);
            }
        }

        return $query;
    }

    /**
     * Scope to order by multiple columns.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array $column
     * @param string $direction
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByColumn(Builder $query, $column = 'created_at', string $direction = 'desc'): Builder
    {
        if (is_array($column)) {
            foreach ($column as $col => $dir) {
                $query->orderBy($col, $dir);
            }
        } else {
            $query->orderBy($column, $direction);
        }

        return $query;
    }
}
