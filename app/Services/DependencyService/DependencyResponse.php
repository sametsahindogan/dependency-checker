<?php

namespace App\Services\DependencyService;

/**
 * Interface DependencyResponse
 * @package App\Services\DependencyService
 */
interface DependencyResponse
{
    /**
     * @return mixed
     */
    public function isSuccessful();

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
    public function getLatestVersion();
}
