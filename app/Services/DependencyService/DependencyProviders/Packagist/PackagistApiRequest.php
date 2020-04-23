<?php

namespace App\Services\DependencyService\DependencyProviders\Packagist;

use App\Services\DependencyService\DependencyProviders\DependencyApiInterfaces\DependencyApiRequest;
use App\Services\DependencyService\DependencyProviders\DependencyApiInterfaces\DependencyApiResponse;
use Sametsahindogan\GuzzleWrapper\Builder\ApiCallBuilder;

/**
 * Class PackagistApiRequest
 * @package App\Services\DependencyService\DependencyProviders\Packagist
 */
class PackagistApiRequest implements DependencyApiRequest
{
    /** @var string $apiUrl */
    protected $apiUrl;

    /**
     * PackagistApiRequest constructor.
     */
    public function __construct()
    {
        $this->apiUrl = config('services.packagist.api_url');
    }

    /**
     * @param string $repo
     * @return PackagistApiResponse
     */
    public function getPackage(string $repo): DependencyApiResponse
    {
        return (new PackagistApiResponse(
            (new ApiCallBuilder($this->apiUrl,'/'.$repo, ApiCallBuilder::HTTP_GET))
                ->call()
        ));
    }
}
