<?php

namespace Hankz\LaravelPlus\Models;

use Hankz\LaravelPlus\Models\Traits\HasUuidModel;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use HasUuidModel;
}
