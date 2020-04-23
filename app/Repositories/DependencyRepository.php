<?php

namespace App\Repositories;

use App\Models\Dependencies\Dependency;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class DependencyRepository
 * @package App\Repositories
 */
class DependencyRepository
{
    /** @var Dependency $model */
    private $model;

    /**
     * DependencyRepository constructor.
     * @param Dependency $model
     */
    public function __construct(Dependency $model)
    {
        $this->model = $model;
    }

    /**
     * @return Builder
     */
    public function deleteAllDependencies(): Builder
    {
        return $this->model::truncate();
    }

    /**
     * @param Dependency $dependency
     * @return bool
     */
    public function setStatusChecking(Dependency $dependency): bool
    {
        return $dependency->checking();
    }

    /**
     * @param Dependency $dependency
     * @return bool
     */
    public function setStatusUptodate(Dependency $dependency): bool
    {
        return $dependency->uptodate();
    }

    /**
     * @param Dependency $dependency
     * @return bool
     */
    public function setStatusOutdated(Dependency $dependency): bool
    {
        return $dependency->outdated();
    }

}
