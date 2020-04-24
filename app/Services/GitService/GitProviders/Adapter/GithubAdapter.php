<?php

namespace App\Services\GitService\Adapter;

use App\Services\GitService\GitProviders\Github\GithubApiRequest;

/**
 * Class GithubAdapter
 * @package App\Services\GitService\Adapter
 */
class GithubAdapter implements GitAdapterInterface
{
    /** @var string $repo */
    protected $repo;

    /**
     * @param string $repo
     * @return GitAdapterInterface
     */
    public function setRepo(string $repo): GitAdapterInterface
    {
        $this->repo = $repo;

        return $this;
    }

    /**
     * @return array
     */
    public function call(): array
    {
        $github = new GithubApiRequest();

        $github->isValidRepository($this->repo);

        return $github->getRepoWithDependencies();
    }
}
