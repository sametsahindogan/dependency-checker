<?php

namespace App\Services\GitService;

use App\Services\GitService\Bitbucket\BitbucketApiRequest;
use App\Services\GitService\Github\GithubApiRequest;
use InvalidArgumentException;

/**
 * Class GitFactory
 * @package App\Services\GitService
 */
class GitFactory
{
    /**
     * @var array
     */
    protected $providers = [
        'github' => GithubApiRequest::class,
        'bitbucket' => BitbucketApiRequest::class,
    ];

    /**
     * @param string $provider
     * @throws \InvalidArgumentException
     */
    public function make(string $provider)
    {
        if (array_key_exists($provider, $this->providers)) {
            $class = $this->providers[$provider];

            return new $class();
        }

        throw new InvalidArgumentException("The [{$provider}] type class is not found!");
    }
}
