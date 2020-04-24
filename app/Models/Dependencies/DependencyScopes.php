<?php


namespace App\Models\Dependencies;


/**
 * Trait DependencyScopes
 * @package App\Models\Dependencies
 */
trait DependencyScopes
{
    /**
     * @return bool
     */
    public function outdated(): bool
    {
        $this->status = Dependency::STATUS_OUTDATED;

        return $this->save();
    }

    /**
     * @return bool
     */
    public function checking(): bool
    {
        $this->status = Dependency::STATUS_CHECKING;

        return $this->save();
    }

    /**
     * @return bool
     */
    public function uptodate(): bool
    {
        $this->status = Dependency::STATUS_UPTODATE;

        return $this->save();
    }
}
