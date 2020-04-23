<?php


namespace App\Repositories;

use App\Models\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;

/**
 * Class GitRepository
 * @package App\Repositories
 */
class GitRepository
{
    /** @var Repository $model */
    private $model;

    /**
     * GitRepository constructor.
     * @param Repository $model
     */
    public function __construct(Repository $model)
    {
        $this->model = $model;
    }

    /**
     * @param string $sort
     * @param string $sortType
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function getAllRepositoriesWithGitProviders(string $sort = 'id', string $sortType = 'desc', int $offset = 0, int $limit = 0): array
    {
        /** @var Builder $queryBuilder */
        $queryBuilder = $this->model->withGitProviders();

        $total = $queryBuilder->count();

        if ($limit > 0 || $offset > 0) {
            $queryBuilder->offset($offset)
                ->limit($limit);
        }

        $datas = $queryBuilder->orderBy($sort, $sortType)
            ->get();

        return [
            'total' => $total,
            'datas' => $datas,
            'offset' => $offset
        ];
    }

    /**
     * @param string $sort
     * @param string $sortType
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function getAllRepositoriesWithGitProvidersAndEmails(string $sort = 'id', string $sortType = 'desc', int $offset = 0, int $limit = 0): array
    {
        /** @var Builder $queryBuilder */
        $queryBuilder = $this->model->withGitProviders()->withEmails();

        $total = $queryBuilder->count();

        if ($limit > 0 || $offset > 0) {
            $queryBuilder->offset($offset)
                ->limit($limit);
        }

        $datas = $queryBuilder->orderBy($sort, $sortType)
            ->get();

        return [
            'total' => $total,
            'datas' => $datas,
            'offset' => $offset
        ];
    }

    /**
     * @param string $sort
     * @param string $sortType
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function getAllRepositoriesWithDependenciesAndEmails(string $sort = 'id', string $sortType = 'desc', int $offset = 0, int $limit = 0): array
    {
        /** @var Builder $queryBuilder */
        $queryBuilder = $this->model->withDependencies()->withEmails();

        $total = $queryBuilder->count();

        if ($limit > 0 || $offset > 0) {
            $queryBuilder->offset($offset)
                ->limit($limit);
        }

        $datas = $queryBuilder->orderBy($sort, $sortType)
            ->get();

        return [
            'total' => $total,
            'datas' => $datas,
            'offset' => $offset
        ];
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getByIdWithDependenciesAndEmails(int $id)
    {
        return $this->model->withDependencies()->withEmails()->find($id);
    }

    /**
     * @param string $repoSlug
     * @param string $projectSlug
     * @return mixed
     */
    public function getRepositoryDependencies(string $repoSlug, string $projectSlug)
    {
        $data = $this->model->withDependencies()->whereSlug($repoSlug, $projectSlug)->first();

        return $data;
    }

    /**
     * @param string $repoSlug
     * @param string $projectSlug
     * @return mixed
     */
    public function getBySlug(string $repoSlug, string $projectSlug)
    {
        return $this->model->whereSlug($repoSlug, $projectSlug)->first();
    }

    /**
     * @param int $typeId
     * @param string $repoUrl
     * @param string $repoId
     * @param array $dependencies
     * @param string $repoSlug
     * @param string $projectSlug
     * @param array $emails
     * @return Repository
     */
    public function create(int $typeId, string $repoUrl, string $repoId, array $dependencies, string $repoSlug, string $projectSlug, array $emails): Repository
    {
        $repository = $this->model::create([
            'status' => $this->model::STATUS_CHECKING,
            'type_id' => $typeId,
            'repo_slug' => $repoSlug,
            'project_slug' => $projectSlug,
            'repo_url' => $repoUrl,
            'repo_id' => $repoId,
        ]);

        $this->createDependencies($repository, $dependencies);
        $repository->emails()->attach($emails);

        return $repository;
    }

    /**
     * @param Repository $repository
     * @param array $dependencies
     * @return Collection
     */
    public function createDependencies(Repository $repository, array $dependencies): Collection
    {
        return $repository->dependencies()->createMany($dependencies);
    }

    /**
     * @param Repository $repository
     * @return bool
     */
    public function setStatusError(Repository $repository): bool
    {
        return $repository->error();
    }

    /**
     * @param Repository $repository
     * @return bool
     */
    public function setStatusChecking(Repository $repository): bool
    {
        return $repository->checking();
    }

    /**
     * @param Repository $repository
     * @return bool
     */
    public function setStatusOutdated(Repository $repository): bool
    {
        return $repository->outdated();
    }

    /**
     * @param Repository $repository
     * @return bool
     */
    public function setStatusUptodate(Repository $repository): bool
    {
        return $repository->uptodate();
    }
}
