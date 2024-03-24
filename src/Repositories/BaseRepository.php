<?php

namespace Hankz\LaravelPlus\Repositories;

use Hankz\LaravelPlus\Repositories\Traits\HasFastlyBuilderRepository;
use Hankz\LaravelPlus\Repositories\Traits\HasUuidRepository;

abstract class BaseRepository extends CrudRepository
{
    use HasUuidRepository;
    use HasFastlyBuilderRepository;
}
