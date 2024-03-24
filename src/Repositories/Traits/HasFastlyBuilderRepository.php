<?php

namespace Hankz\LaravelPlus\Repositories\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use ReflectionClass;

trait HasFastlyBuilderRepository
{
    abstract public function newQuery(): Builder;

    /**
     * @return Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function getModels(array $filters = [], $with = null, $sort = 'id', $order = 'desc', $paginate = null, $columns = ['*'])
    {
        $query = $this->applyQuery($filters, $with, $sort, $order);

        if ($paginate) {
            return $query->paginate((int)$paginate, $columns);
        }

        return $query->get($columns);
    }

    public function exists(array $filters = []): bool
    {
        $query = $this->applyQuery($filters);

        return $query->exists();
    }

    public function count(array $filters = []): int
    {
        $query = $this->applyQuery($filters);

        return $query->count();
    }

    public function applyQuery(array $filters = [], $with = null, $sort = 'id', $order = 'desc', Builder $query = null): Builder
    {
        if (!$query) {
            $query = $this->newQuery();
        }

        if ($filters) {
            $query = $this->applyFilterByQuery($query, $filters);
        }

        if ($with) {
            $query = $this->applyWithByQuery($query, $with);
        }

        return $this->applyOrderByQuery($query, $sort, $order);
    }

    public function applyOrderByQuery(Builder $query, $sort = 'id', $order = 'desc'): Builder
    {
        return $query->orderBy($sort, $order);
    }

    public function applyWithByQuery(Builder $query, $with = null): Builder
    {
        return $query->with($with);
    }

    public function applyWithCountByQuery(Builder $query, $relations = null): Builder
    {
        return $query->withCount($relations);
    }

    public function applyWithSumByQuery(Builder $query, $relation = null, $relationColumn = null): Builder
    {
        return $query->withSum($relation, $relationColumn);
    }

    /**
     * Match filter and build query.
     */
    public function applyFilterByQuery(Builder $query, array $filters = []): Builder
    {
        if (!empty($filters)) {
            $query = $this->filter($filters, $query, $this->getFilterNamespace());
        }

        return $query;
    }

    public static function filter(array $filters, Builder $query, string $nameSpace): Builder
    {
        $query = static::filterDecoratorsFromRequest($query, $nameSpace, $filters);

        return $query;
    }

    /**
     * Get filter namespace.
     */
    protected function getFilterNamespace(): string
    {
        $reflectionClass = new ReflectionClass(static::class);

        return $reflectionClass->getNamespaceName() . '\Filters\\';
    }

    protected static function createFilterDecorator($name, $nameSpace)
    {
        return $nameSpace . Str::studly($name);
    }

    private static function filterDecoratorsFromRequest(Builder $query, $nameSpace, array $request = []): Builder
    {
        foreach ($request as $filterName => $value) {
            if (isset($value)) {
                $decorator = static::createFilterDecorator($filterName, $nameSpace);
                if (static::isValidDecorator($decorator)) {
                    $query = $decorator::applyFilter($query, $value);
                }
            }
        }

        return $query;
    }

    private static function isValidDecorator($decorator): bool
    {
        return class_exists($decorator);
    }
}
