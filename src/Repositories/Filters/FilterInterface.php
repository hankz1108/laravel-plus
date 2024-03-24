<?php

namespace Hankz\LaravelPlus\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public static function applyFilter(Builder $query, $value): Builder;
}
