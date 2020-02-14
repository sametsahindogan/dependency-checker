<?php

namespace App\Services\GitService\Github;

use App\Models\Dependency;
use App\Services\GitService\Dependencies\FetchNpm;
use App\Services\GitService\Dependencies\FetchPackagist;
use App\Services\GitService\GitRequest;
use App\Services\GitService\GitResponse;
use Sametsahindogan\GuzzleWrapper\Builder\ApiCallBuilder;

/**
 * Class GithubApiRequest
 * @package App\Services\GitService\Github
 */
class GithubApiRequest implements GitRequest
{
    /** @var string $apiUrl */
    protected $apiUrl;

    /**
     * GithubApiRequest constructor.
     */
    public function __construct()
    {
        $this->apiUrl = config('services.github.api_url');
    }

    /**
     * @param string $repo
     * @return GitResponse|array|bool|string
     */
    public function getRepoWithDependencies(string $repo)
    {
        $repo = $this->getRepo($repo);

        if (!$repo->isSuccessful()) return $repo;

        $packagist = $this->checkFile($repo->getRepoId(), Dependency::FILE_PACKAGIST);
        $npm = $this->checkFile($repo->getRepoId(), Dependency::FILE_NPM);

        return $this->dependency($repo->getRepoId(), (new FetchPackagist())->execute($packagist), (new FetchNpm())->execute($npm));
    }

    /**
     * @param string $repo
     * @return GitResponse
     */
    public function getRepo(string $repo): GitResponse
    {
        return (new GithubApiResponse(
            (new ApiCallBuilder($this->apiUrl,'/repos/' . trim($repo), ApiCallBuilder::HTTP_GET))
                ->call()
        ));
    }

    /**
     * @param string $repoId
     * @param string $file
     * @return GithubApiResponse
     */
    public function checkFile(string $repoId, string $file): GitResponse
    {
        return (new GithubApiResponse(
            (new ApiCallBuilder($this->apiUrl,'/repositories/' . trim($repoId) . '/contents/' . $file, ApiCallBuilder::HTTP_GET))
                ->call()
        ));
    }

    /**
     * @param string $gitRepoId
     * @param FetchPackagist $packagist
     * @param FetchNpm $npm
     * @return array
     */
    public function dependency(string $gitRepoId, FetchPackagist $packagist, FetchNpm $npm): array
    {
        $dependencies = array_merge($packagist->getDependencies(), $npm->getDependencies());

        return [
            'dependencies' => $dependencies,
            'repo_id' => $gitRepoId
        ];
    }

}
