<?php

namespace Hankz\Plus\App\Models;

use Hankz\Plus\App\Models\Interfaces\HasUuid;
use Hankz\Plus\App\Models\Traits\Uuidable;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model implements HasUuid
{
    use Uuidable;
}
