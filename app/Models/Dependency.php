<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Dependency
 * @package App\Models
 */
class Dependency extends Model
{
    /** @var int  */
    const TYPE_PACKAGIST = 1;

    /** @var string */
    const FILE_PACKAGIST = 'composer.json';

    /** @var int  */
    const TYPE_NPM = 2;

    /** @var string */
    const FILE_NPM = 'package.json';

    /** @var string  */
    const STATUS_CHECKING = 'checking';

    /** @var string  */
    const STATUS_OUTDATED = 'outdated';

    /** @var string  */
    const STATUS_UPTODATE = 'uptodate';

    /** @var string $table */
    protected $table = "dependencies";

    /** @var array $guarded */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(DependencyType::class,'type_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function repository()
    {
        return $this->belongsTo(Repository::class,'repository_id','id');
    }

}
