<?php

namespace App\Services\GitService\GitProviders\Github;

use App\Models\Dependencies\Dependency;
use App\Services\GitService\GitProviders\DependencyFileParser\NpmParser;
use App\Services\GitService\GitProviders\DependencyFileParser\PackagistParser;
use App\Services\GitService\GitProviders\GitApiInterfaces\GitApiRequest;
use App\Services\GitService\GitProviders\GitApiInterfaces\GitApiResponse;
use Sametsahindogan\GuzzleWrapper\Builder\ApiCallBuilder;

/**
 * Class GithubApiRequest
 * @package App\Services\GitService\GitProviders\Github
 */
class GithubApiRequest implements GitApiRequest
{
    /** @var string $apiUrl */
    protected $apiUrl;

    /** @var GitApiResponse $repository */
    protected $repository;

    /**
     * GithubApiRequest constructor.
     */
    public function __construct()
    {
        $this->apiUrl = config('services.github.api_url');
    }

    /**
     * @param string $repo
     * @return bool
     */
    public function isValidRepository(string $repo): bool
    {
        $this->repository = (new GithubApiResponse(
            (new ApiCallBuilder($this->apiUrl,'/repos/' . trim($repo), ApiCallBuilder::HTTP_GET))
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
     * @param string $repoId
     * @param string $file
     * @return GitApiResponse
     */
    protected function checkDependencyFile(string $repoId, string $file): GitApiResponse
    {
        return (new GithubApiResponse(
            (new ApiCallBuilder($this->apiUrl,'/repositories/' . trim($repoId) . '/contents/' . $file, ApiCallBuilder::HTTP_GET))
                ->call()
        ));
    }
}
