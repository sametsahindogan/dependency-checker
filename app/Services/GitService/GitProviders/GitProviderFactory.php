<?php

namespace App\Services\GitService\GitProviders;

use App\Services\GitService\GitProviders\Bitbucket\BitbucketApiRequest;
use App\Services\GitService\GitProviders\Github\GithubApiRequest;
use InvalidArgumentException;

/**
 * Class GitProviderFactory
 * @package App\Services\GitService\GitProviders
 */
class GitProviderFactory
{
    /** @var array $providers */
    protected $providers = [
        'github' => GithubApiRequest::class,
        'bitbucket' => BitbucketApiRequest::class,
    ];

    /**
     * @param string $provider
     * @return GithubApiRequest
     */
    public function make(string $provider): GithubApiRequest
    {
        if (array_key_exists($provider, $this->providers)) {
            $class = $this->providers[$provider];

            return new $class();
        }

        throw new InvalidArgumentException("The [{$provider}] type class is not found!");
    }
}
