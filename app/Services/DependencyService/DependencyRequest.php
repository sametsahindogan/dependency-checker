<?php


namespace App\Services\DependencyService;

/**
 * Interface RequestInterface
 * @package App\Services\DependencyService
 */
interface DependencyRequest
{
    /**
     * @param string $repo
     * @return mixed
     */
    public function getPackage(string $repo);
}
