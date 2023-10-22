<?php

namespace Hankz\Plus\App\Models\Traits;

use Illuminate\Support\Str;

trait Uuidable
{
    /**
     * Indicates if the UUIDs are auto-generating.
     *
     * @var bool
     */
    public $generating = true;

    /**
     * The uuid key for the model.
     *
     * @var string
     */
    protected $uuidKey = 'uuid';

    /**
     * Get the value indicating whether the UUIDs are generating.
     */
    public function getGenerating(): bool
    {
        return $this->generating;
    }

    /**
     * Get the uuid key for the model.
     */
    public function getUuidKeyName(): string
    {
        return $this->uuidKey;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function firstOrFailByUUID(string $uuid)
    {
        return $this->where($this->getUuidKeyName(), $uuid)->firstOrFail();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findByUUID(string $uuid)
    {
        return $this->where($this->getUuidKeyName(), $uuid)->first();
    }

    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->getGenerating()) {
                if (empty($model->{$model->getUuidKeyName()})) {
                    $model->{$model->getUuidKeyName()} = Str::uuid()->toString();
                }
            }
        });
    }
}
