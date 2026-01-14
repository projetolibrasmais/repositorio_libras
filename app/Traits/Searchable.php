<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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

        $searchableColumns = $columns ?? $this->searchable ?? ['name'];

        return $query->where(function (Builder $query) use ($search, $searchableColumns) {
            foreach ($searchableColumns as $column) {
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
     * Scope to apply advanced filters dynamically based on model's $filterable property.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request|array $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApplyFilters(Builder $query, $request): Builder
    {
        $filters = is_array($request) ? $request : $request->all();
        $filterable = $this->filterable ?? [];

        foreach ($filterable as $key => $operator) {
            if (str_contains($key, ':')) {
                [$requestKey, $dbColumn] = explode(':', $key);
            } else {
                $requestKey = $key;
                $dbColumn = $key;
            }

            if (!isset($filters[$requestKey]) || $filters[$requestKey] === '' || $filters[$requestKey] === null) {
                continue;
            }

            $value = $filters[$requestKey];

            $this->applyFilterByOperator($query, $dbColumn, $value, $operator, $requestKey);
        }

        return $query;
    }

    /**
     * Apply filter based on operator type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param mixed $value
     * @param string $operator
     * @param string $requestKey
     * @return void
     */
    protected function applyFilterByOperator(Builder $query, string $column, $value, string $operator, string $requestKey): void
    {
        switch (strtolower($operator)) {
            case 'like':
                if (str_contains($column, '.')) {
                    $this->applyRelationFilter($query, $column, $value, 'LIKE');
                } else {
                    $query->where($column, 'LIKE', "%{$value}%");
                }
                break;

            case '=':
            case 'exact':
                if (str_contains($column, '.')) {
                    $this->applyRelationFilter($query, $column, $value, '=');
                } else {
                    $query->where($column, '=', $value);
                }
                break;

            case 'in':
                $values = is_array($value) ? $value : [$value];
                $query->whereIn($column, $values);
                break;

            case 'date_from':
            case '>=':
                $query->whereDate($column, '>=', $value);
                break;

            case 'date_to':
            case '<=':
                $query->whereDate($column, '<=', $value);
                break;

            case '>':
                $query->where($column, '>', $value);
                break;

            case '<':
                $query->where($column, '<', $value);
                break;

            case 'between':
                if (is_array($value) && count($value) === 2) {
                    $query->whereBetween($column, $value);
                }
                break;

            default:
                // Default to exact match
                $query->where($column, $value);
                break;
        }
    }

    /**
     * Apply filter for relationship columns.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param mixed $value
     * @param string $operator
     * @return void
     */
    protected function applyRelationFilter(Builder $query, string $column, $value, string $operator = '='): void
    {
        $parts = explode('.', $column);
        $relation = $parts[0];
        $relatedColumn = $parts[1];

        $query->whereHas($relation, function (Builder $query) use ($relatedColumn, $value, $operator) {
            if ($operator === 'LIKE') {
                $query->where($relatedColumn, 'LIKE', "%{$value}%");
            } else {
                $query->where($relatedColumn, $operator, $value);
            }
        });
    }

    /**
     * Scope to apply filters dynamically (legacy support).
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

            if ($key === 'search') {
                continue;
            }

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

    /**
     * Scope to handle soft delete filters.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $showDeleted
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithDeletedFilter(Builder $query, ?string $showDeleted): Builder
    {
        if (!$showDeleted) {
            return $query;
        }

        switch ($showDeleted) {
            case 'only':
                $query->onlyTrashed();
                break;
            case 'with':
                $query->withTrashed();
                break;
        }

        return $query;
    }
}
