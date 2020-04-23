<?php

namespace App\Services\GitService\Adapter;

use App\Services\GitService\GitProviders\Bitbucket\BitbucketApiRequest;

/**
 * Class BitbucketAdapter
 * @package App\Services\GitService\Adapter
 */
class BitbucketAdapter implements GitAdapterInterface
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
        $bitbucket = new BitbucketApiRequest();

        $bitbucket->isValidRepository($this->repo);

        return $bitbucket->getRepoWithDependencies();
    }
}
