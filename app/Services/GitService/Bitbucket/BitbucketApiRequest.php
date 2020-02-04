<?php

namespace App\Services\GitService\Bitbucket;

use App\Models\Dependency;
use App\Services\ApiService\ApiCallBuilder;
use App\Services\GitService\Dependencies\FetchNpm;
use App\Services\GitService\Dependencies\FetchPackagist;
use App\Services\GitService\GitRequest;
use App\Services\GitService\GitResponse;

/**
 * Class BitbucketApiRequest
 * @package App\Services\GitService\Bitbucket
 */
class BitbucketApiRequest implements GitRequest
{
    /** @var string $apiUrl */
    protected $apiUrl;

    /**
     * GithubApiRequest constructor.
     */
    public function __construct()
    {
        $this->apiUrl = config('services.bitbucket.api_url');
    }

    /**
     * @param string $repo
     * @return GitResponse|bool|array
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
        return (new BitbucketApiResponse(
            (new ApiCallBuilder('/2.0/repositories/' . trim($repo), $this->apiUrl))
                ->call()
        ));
    }

    /**
     * @param string $repoSlug
     * @param string $file
     * @return GitResponse
     */
    public function checkFile(string $repoSlug, string $file): GitResponse
    {
        return (new BitbucketApiResponse(
            (new ApiCallBuilder('/2.0/repositories/' . $repoSlug . '/src/master/' . $file, $this->apiUrl))
                ->call()
        ));
    }

    /**
     * @param string $gitRepoId
     * @param FetchPackagist $packagist
     * @param FetchNpm $npm
     * @return mixed
     */
    public function dependency(string $gitRepoId, FetchPackagist $packagist, FetchNpm $npm)
    {
        $dependencies = array_merge($packagist->getDependencies(), $npm->getDependencies());

        return [
            'dependencies' => $dependencies,
            'repo_id' => $gitRepoId
        ];
    }
}
