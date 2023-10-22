<?php

namespace Hankz\Plus\App\Models\Interfaces;

interface HasUuid
{
    /**
     * Get the value indicating whether the UUIDs are generating.
     *
     * @return bool
     */
    public function getGenerating();

    /**
     * Get the uuid key for the model.
     *
     * @return string
     */
    public function getUuidKeyName();
}
