<?php

namespace App\Services\ApiService;

use App\Services\DependencyService\Npm\NpmApiRequest;
use App\Services\DependencyService\Packagist\PackagistApiRequest;
use InvalidArgumentException;

/**
 * Class DependencyFactory
 * @package App\Services\ApiService
 */
class DependencyFactory
{
    /**
     * @var array
     */
    protected $requests = [
        'npm'          => NpmApiRequest::class,
        'packagist'    => PackagistApiRequest::class,
    ];

    /**
     * @param  string  $type
     * @throws \InvalidArgumentException
     */
    public function make(string $type)
    {
        if (array_key_exists($type, $this->requests)) {
            $class = $this->requests[$type];

            return new $class();
        }

        throw new InvalidArgumentException("The [{$type}] type class is not found!");
    }
}
