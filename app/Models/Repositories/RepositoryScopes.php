<?php


namespace App\Models\Repositories;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait RepositoryScopes
 * @package App\Models\Repositories
 */
trait RepositoryScopes
{
    /**
     * @param Builder $query
     * @param string $repoSlug
     * @param string $projectSlug
     * @return Builder
     */
    public function scopeWhereSlug(Builder $query, string $repoSlug, string $projectSlug): Builder
    {
        return $query->where(['repo_slug' => $repoSlug, 'project_slug' => $projectSlug]);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithDependencies(Builder $query): Builder
    {
        return $query->with(['dependencies' => function ($query) {
            $query->with('type');
        }]);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithGitProviders(Builder $query): Builder
    {
        return $query->with('gitProvider');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithEmails(Builder $query): Builder
    {
        return $query->with('emails');
    }

    /**
     * @return bool
     */
    public function error(): bool
    {
        $this->checked_at = now();
        $this->status = Repository::STATUS_ERROR;
        return $this->save();
    }

    /**
     * @return bool
     */
    public function checking(): bool
    {
        $this->checked_at = now();
        $this->status = Repository::STATUS_CHECKING;
        return $this->save();
    }

    /**
     * @return bool
     */
    public function outdated(): bool
    {
        $this->checked_at = now();
        $this->status = Repository::STATUS_OUTDATED;
        return $this->save();
    }

    /**
     * @return bool
     */
    public function uptodate(): bool
    {
        $this->checked_at = now();
        $this->status = Repository::STATUS_UPTODATE;
        return $this->save();
    }
}
