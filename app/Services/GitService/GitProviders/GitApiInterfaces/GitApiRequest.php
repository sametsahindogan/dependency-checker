<?php

namespace App\Services\GitService\GitProviders\GitApiInterfaces;

/**
 * Interface GitApiRequest
 * @package App\Services\GitService\GitProviders\GitApiInterfaces
 */
interface GitApiRequest
{
    /**
     * @param string $repo
     * @return bool
     */
    public function isValidRepository(string $repo): bool;

    /**
     * @return array
     */
    public function getRepoWithDependencies(): array;
}
