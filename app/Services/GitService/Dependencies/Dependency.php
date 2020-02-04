<?php

namespace App\Services\GitService\Dependencies;

use App\Services\DependencyService\DependencyResponse;
use App\Services\GitService\GitResponse;

/**
 * Interface Dependency
 * @package App\Services\GitService\Dependencies
 */
interface Dependency
{
    /**
     * @return array
     */
    public function getDependencies();

    /**
     * @param GitResponse $response
     * @return DependencyResponse
     */
    public function execute(GitResponse $response);

    /**
     * @param GitResponse $response
     * @param string $key
     * @return bool|mixed
     */
    public function checkKey(GitResponse $response, string $key);

    /**
     * @param string $version
     * @return mixed
     */
    public function formatVersion(string $version);

    /**
     * @param GitResponse $response
     * @return mixed
     */
    public function getContent(GitResponse $response);

    /**
     * @return mixed
     */
    public function saveDependencies();

}
