<?php

namespace App\Services\GitService\Adapter;

use App\Services\GitService\Github\GithubApiRequest;

class GithubAdapter implements GitAdapterInterface
{
    protected $repo;

    public function setRepo(string $repo): self
    {
        $this->repo = $repo;
        return $this;
    }

    public function call()
    {
        return (new GithubApiRequest())->getRepoWithDependencies($this->repo);
    }
}
