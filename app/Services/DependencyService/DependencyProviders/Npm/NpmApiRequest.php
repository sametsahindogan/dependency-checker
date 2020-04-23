<?php

namespace App\Services\DependencyService\DependencyProviders\Npm;

use App\Services\DependencyService\DependencyProviders\DependencyApiInterfaces\DependencyApiRequest;
use App\Services\DependencyService\DependencyProviders\DependencyApiInterfaces\DependencyApiResponse;
use Sametsahindogan\GuzzleWrapper\Builder\ApiCallBuilder;

/**
 * Class NpmApiRequest
 * @package App\Services\DependencyService\DependencyProviders\Npm
 */
class NpmApiRequest implements DependencyApiRequest
{
    /** @var string $apiUrl */
    protected $apiUrl;

    /**
     * NpmApiRequest constructor.
     */
    public function __construct()
    {
        $this->apiUrl = config('services.npm.api_url');
    }

    /**
     * @param string $repo
     * @return DependencyApiResponse
     */
    public function getPackage(string $repo): DependencyApiResponse
    {
        return (new NpmApiResponse(
            (new ApiCallBuilder($this->apiUrl, '/' . trim($repo), ApiCallBuilder::HTTP_GET))
                ->call()
        ));
    }
}
