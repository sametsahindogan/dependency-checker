<?php

namespace App\Services\GitService;

/**
 * Interface GitResponse
 * @package App\Services\GitService
 */
interface GitResponse
{
    /**
     * @return mixed
     */
    public function isSuccessful();

    /**
     * @return mixed
     */
    public function getData();

    /**
     * @return mixed
     */
    public function getError();

    /**
     * @return mixed
     */
    public function getStatusCode();

    /**
     * @return mixed
     */
    public function getDecoded();

    /**
     * @return mixed
     */
    public function getRepoId();

    /**
     * @return mixed
     */
    public function getFileContent();

    /**
     * @return mixed
     */
    public function getEncodeType();

}
