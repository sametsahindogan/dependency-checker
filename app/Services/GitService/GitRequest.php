<?php

namespace App\Services\GitService;

use App\Services\GitService\Dependencies\FetchNpm;
use App\Services\GitService\Dependencies\FetchPackagist;

/**
 * Interface GitRequest
 * @package App\Services\GitService
 */
interface GitRequest
{
    /**
     * @param string $repo
     * @return GitResponse|bool|array
     */
    public function getRepoWithDependencies(string $repo);

    /**
     * @param string $repo
     * @return GitResponse
     */
    public function getRepo(string $repo): GitResponse;

    /**
     * @param string $repoId
     * @param string $file
     * @return GitResponse
     */
    public function checkFile(string $repoId, string $file): GitResponse;

    /**
     * @param string $gitRepoId
     * @param FetchPackagist $packagist
     * @param FetchNpm $npm
     * @return array
     */
    public function dependency(string $gitRepoId, FetchPackagist $packagist, FetchNpm $npm);

}
