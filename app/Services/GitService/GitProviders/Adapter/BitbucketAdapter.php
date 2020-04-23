<?php

namespace App\Services\GitService\Adapter;

use App\Services\GitService\Bitbucket\BitbucketApiRequest;

class BitbucketAdapter implements GitAdapterInterface
{
    protected $repo;

    public function setRepo(string $repo): self
    {
        $this->repo = $repo;
        return $this;
    }

    public function call()
    {
        return (new BitbucketApiRequest())->getRepoWithDependencies($this->repo);
    }
}
