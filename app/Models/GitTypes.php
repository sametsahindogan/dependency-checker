<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GitTypes
 * @package App\Models
 */
class GitTypes extends Model
{

    /** @var string $table */
    protected $table = "git_types";

    /** @var array $guarded */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function repositories()
    {
        return $this->hasMany(Repository::class, 'repository_id', 'id');
    }

}
