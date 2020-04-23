<?php

namespace App\Services\DependencyService\DependencyProviders\DependencyApiInterfaces;

/**
 * Interface DependencyApiResponse
 * @package App\Services\DependencyService\DependencyProviders\DependencyApiInterfaces
 */
interface DependencyApiResponse
{
    /**
     * @return bool
     */
    public function isSuccessful(): bool;

    /**
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * @return mixed
     */
    public function getDecoded();

    /**
     * @return string
     */
    public function getLatestVersion(): string;
}
