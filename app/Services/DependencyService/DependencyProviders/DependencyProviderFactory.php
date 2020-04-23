<?php

namespace App\Services\DependencyService\DependencyProviders;

use App\Services\DependencyService\DependencyProviders\DependencyApiInterfaces\DependencyApiRequest;
use App\Services\DependencyService\DependencyProviders\Npm\NpmApiRequest;
use App\Services\DependencyService\DependencyProviders\Packagist\PackagistApiRequest;
use InvalidArgumentException;

/**
 * Class DependencyProviderFactory
 * @package App\Services\DependencyService\DependencyProviders
 */
class DependencyProviderFactory
{
    /** @var array $providers */
    protected $providers = [
        'npm'          => NpmApiRequest::class,
        'packagist'    => PackagistApiRequest::class,
    ];

    /**
     * @param string $type
     * @return DependencyApiRequest
     */
    public function make(string $type): DependencyApiRequest
    {
        if (array_key_exists($type, $this->providers)) {
            $class = $this->providers[$type];

            return new $class();
        }

        throw new InvalidArgumentException("The [{$type}] type class is not found!");
    }
}
