<?php

namespace App\Services\GitService\Adapter;

/**
 * Class GitManager
 * @package App\Services\GitService\Adapter
 */
class GitManager
{
    /**
     * @param GitAdapterInterface $gitAdapter
     * @param string $repo
     * @return array
     */
    public function getRepoWithDependencies(GitAdapterInterface $gitAdapter, string $repo)
    {
        return $gitAdapter->setRepo($repo)->call();
    }
}
