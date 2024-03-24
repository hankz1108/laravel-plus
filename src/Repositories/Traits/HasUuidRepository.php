<?php

namespace Hankz\LaravelPlus\Repositories\Traits;

use Hankz\LaravelPlus\Models\Traits\HasUuidModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait HasUuidRepository
{
    /**
     * The default uuid column name for the model.
     *
     * @var string
     */
    protected $uuidColumn = 'uuid';

    abstract public function newQuery(): Builder;

    /**
     * @return Model|null
     */
    public function findByUUID(string $uuid)
    {
        return $this->newQuery()->where($this->getUuidColumnName(), $uuid)->first();
    }

    /**
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFailByUUID(string $uuid): ?Model
    {
        return $this->newQuery()
            ->where($this->getUuidColumnName(), $uuid)
            ->firstOrFail();
    }

    public function getByUuids(array $uuids): Collection
    {
        return $this->newQuery()
            ->whereIn($this->getUuidColumnName(), $uuids)
            ->get();
    }

    public function updateByUuid(mixed $uuid, array $attributes = [], array $options = []): int
    {
        $query = $this->newQuery();

        if (is_array($uuid)) {
            $query->whereIn($this->getUuidColumnName(), $uuid);
        } else {
            $query->where($this->getUuidColumnName(), $uuid);
        }

        return $query->update($attributes, $options);
    }

    public function deleteByUuid(mixed $uuid): mixed
    {
        $query = $this->newQuery();

        if (is_array($uuid)) {
            $query->whereIn($this->getUuidColumnName(), $uuid);
        } else {
            $query->where($this->getUuidColumnName(), $uuid);
        }

        return $query->delete();
    }

    private function getUuidColumnName(): string
    {
        if ($this->model instanceof HasUuidModel) {
            return $this->model->getUuidColumnName();
        }

        return $this->uuidColumn;
    }
}
