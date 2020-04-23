<?php

namespace App\Models\Dependencies;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DependencyType
 * @package App\Models
 */
class DependencyType extends Model
{
    /** @var string $table */
    protected $table = "dependency_types";

    /** @var array $guarded */
    protected $guarded = [];
}
