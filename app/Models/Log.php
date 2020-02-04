<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Log
 * @package App\Models
 */
class Log extends Model
{
    /** @var string $table */
    protected $table = "logs";

    /** @var array $guarded */
    protected $guarded = [];
}
