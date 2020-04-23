<?php


namespace App\Services\DependencyService\DependencyProviders\DependencyApiInterfaces;

/**
 * Interface DependencyApiRequest
 * @package App\Services\DependencyService\DependencyProviders\DependencyApiInterfaces
 */
interface DependencyApiRequest
{
    /**
     * @param string $repo
     * @return DependencyApiResponse
     */
    public function getPackage(string $repo): DependencyApiResponse;
}
