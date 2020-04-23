<?php

namespace App\Models\Emails;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Email
 * @package App\Models
 */
class Email extends Model
{
    use SoftDeletes, EmailScopes;

    /** @var string $table */
    protected $table = "emails";

    /** @var array $guarded */
    protected $guarded = [];
}
