<?php

namespace Hankz\LaravelPlus\Models\Traits;

use Illuminate\Support\Str;

trait HasUuidModel
{
    /**
     * Indicates if the UUIDs are auto-generating.
     *
     * @var bool
     */
    public $generating = true;

    /**
     * The uuid column for the model.
     *
     * @var string
     */
    protected $uuidColumn = 'uuid';

    /**
     * Get the value indicating whether the UUIDs are generating.
     */
    public function getGenerating(): bool
    {
        return $this->generating;
    }

    /**
     * Get the uuid column for the model.
     */
    public function getUuidColumnName(): string
    {
        return $this->uuidColumn;
    }

    /**
     * Boot function from Laravel.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->getGenerating()) {
                if (empty($model->{$model->getUuidColumnName()})) {
                    $model->{$model->getUuidColumnName()} = Str::uuid()->toString();
                }
            }
        });
    }
}
