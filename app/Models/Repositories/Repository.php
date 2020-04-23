<?php

namespace App\Models\Repositories;

use App\Models\Dependencies\Dependency;
use App\Models\Emails\Email;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Repository
 * @package App\Models
 */
class Repository extends Model
{
    use RepositoryScopes;

    /** @var string */
    const STATUS_CHECKING = 'checking';

    /** @var string */
    const STATUS_OUTDATED = 'outdated';

    /** @var string */
    const STATUS_UPTODATE = 'uptodate';

    /** @var string */
    const STATUS_ERROR = 'error';

    /** @var string $table */
    protected $table = "repositories";

    /** @var array $guarded */
    protected $guarded = [];

    /** @var array $dates */
    protected $dates = ['checked_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dependencies()
    {
        return $this->hasMany(Dependency::class, 'repository_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gitProvider()
    {
        return $this->belongsTo(GitTypes::class, 'type_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function emails()
    {
        return $this->belongsToMany(Email::class, 'repository_email');
    }
}
