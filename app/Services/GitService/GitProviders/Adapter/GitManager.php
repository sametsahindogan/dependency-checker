<?php

namespace App\Services\GitService\Adapter;

class GitManager
{
    public function getRepoWithDependencies(GitAdapterInterface $gitAdapter, string $repo)
    {
        return $gitAdapter->setRepo($repo)->call();
    }
}
