<?php

namespace Hankz\LaravelPlus\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

abstract class CrudRepository
{
    /**
     * @var Model
     */
    protected $model;

    public function newQuery(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * ====================Read Functions====================.
     */
    public function find(mixed $id, array $columns = ['*']): ?Model
    {
        return $this->newQuery()->find($id, $columns);
    }

    public function findOrFail(mixed $id): Model
    {
        return $this->newQuery()->findOrFail($id);
    }

    public function findBy(string $column, $value, array $columns = ['*']): ?Model
    {
        return $this->newQuery()->where($column, $value)->first($columns);
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->newQuery()->all($columns);
    }

    public function get(array $columns = ['*']): Collection
    {
        return $this->newQuery()->get($columns);
    }

    public function getBy(string $column, $value, array $columns = ['*']): Collection
    {
        return $this->newQuery()->where($column, $value)->get($columns);
    }

    public function first(array $columns = ['*']): ?Model
    {
        return $this->newQuery()->first($columns);
    }

    /**
     * ====================Create Functions====================.
     */
    public function create(array $attributes): Model
    {
        return $this->newQuery()->create($attributes);
    }

    /**
     * ====================Update Functions====================.
     */

    /**
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update(mixed $id, array $attributes, array $options = []): bool
    {
        $instance = $this->newQuery()->findOrFail($id);

        return $instance->update($attributes, $options);
    }

    public function updateBy(mixed $column, mixed $value, array $attributes = [], array $options = []): int
    {
        return $this->newQuery()->where($column, $value)->update($attributes, $options);
    }

    /**
     * ====================Delete Functions====================.
     */

    /**
     * @param \Illuminate\Support\Collection|array|int|string $ids
     */
    public function delete(mixed $ids): int
    {
        return $this->model->destroy($ids);
    }

    public function deleteBy(mixed $column, $value)
    {
        return $this->newQuery()->where($column, $value)->delete();
    }

    /**
     * ====================Paginate Functions====================.
     */

    /**
     * @param int|null $perPage
     * @param int|null $page
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws InvalidArgumentException
     */
    public function paginate($perPage = null, array $columns = ['*'], string $pageName = 'page', $page = null)
    {
        return $this->newQuery()->paginate($perPage, $columns, $pageName, $page);
    }

    /**
     * @param int|null $perPage
     * @param int|null $page
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws InvalidArgumentException
     */
    public function paginateBy(string $column, $value, $perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return $this->newQuery()->where($column, $value)->paginate($perPage, $columns, $pageName, $page);
    }
}
