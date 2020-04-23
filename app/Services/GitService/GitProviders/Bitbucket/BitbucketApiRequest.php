<?php

namespace App\Services\GitService\GitProviders\Bitbucket;

use App\Models\Dependencies\Dependency;
use App\Services\GitService\GitProviders\DependencyFileParser\NpmParser;
use App\Services\GitService\GitProviders\DependencyFileParser\PackagistParser;
use App\Services\GitService\GitProviders\GitApiInterfaces\GitApiRequest;
use App\Services\GitService\GitProviders\GitApiInterfaces\GitApiResponse;
use Sametsahindogan\GuzzleWrapper\Builder\ApiCallBuilder;

/**
 * Class BitbucketApiRequest
 * @package App\Services\GitService\GitProviders\Bitbucket
 */
class BitbucketApiRequest implements GitApiRequest
{
    /** @var string $apiUrl */
    protected $apiUrl;

    /** @var GitApiResponse $repository */
    protected $repository;

    /**
     * BitbucketApiRequest constructor.
     */
    public function __construct()
    {
        $this->apiUrl = config('services.bitbucket.api_url');
    }

    /**
     * @param string $repo
     * @return bool
     */
    public function isValidRepository(string $repo): bool
    {
        $this->repository = (new BitbucketApiResponse(
            (new ApiCallBuilder($this->apiUrl, '/2.0/repositories/' . trim($repo), ApiCallBuilder::HTTP_GET))
                ->call()
        ));

        return $this->repository->isSuccessful();
    }

    /**
     * @return array
     */
    public function getRepoWithDependencies(): array
    {
        $repositoryId = $this->repository->getRepoId();

        $packagistFile = $this->checkDependencyFile($repositoryId, Dependency::FILE_PACKAGIST);
        $npmFile = $this->checkDependencyFile($repositoryId, Dependency::FILE_NPM);

        $packagist = (new PackagistParser())->execute($packagistFile)->getDependencies();
        $npm = (new NpmParser())->execute($npmFile)->getDependencies();

        return [
            'dependencies' => array_merge($packagist, $npm),
            'repo_id' => $repositoryId
        ];
    }

    /**
     * @param string $repoSlug
     * @param string $file
     * @return GitApiResponse
     */
    protected function checkDependencyFile(string $repoSlug, string $file): GitApiResponse
    {
        return (new BitbucketApiResponse(
            (new ApiCallBuilder($this->apiUrl, '/2.0/repositories/' . $repoSlug . '/src/master/' . $file, ApiCallBuilder::HTTP_GET))
                ->call()
        ));
    }
}
