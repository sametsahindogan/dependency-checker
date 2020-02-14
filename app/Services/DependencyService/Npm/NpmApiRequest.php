<?php

namespace App\Services\DependencyService\Npm;

use App\Services\DependencyService\DependencyRequest;
use Sametsahindogan\GuzzleWrapper\Builder\ApiCallBuilder;

/**
 * Class NpmApiRequest
 * @package App\Services\DependencyService\Npm
 */
class NpmApiRequest implements DependencyRequest
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
     * @return NpmApiResponse
     */
    public function getPackage(string $repo)
    {
        return (new NpmApiResponse(
            (new ApiCallBuilder($this->apiUrl,'/'.trim($repo), ApiCallBuilder::HTTP_GET))
                ->call()
        ));
    }
}
