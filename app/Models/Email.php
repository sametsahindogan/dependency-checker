<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Email
 * @package App\Models
 */
class Email extends Model
{
    use SoftDeletes;

    /** @var string $table */
    protected $table = "emails";

    /** @var array $guarded */
    protected $guarded = [];
}
