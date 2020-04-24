<?php


namespace App\Services\GitService\Helper;

use App\Models\Repositories\GitTypes;

/**
 * Class GitServiceHelper
 * @package App\Services\GitService\Helper
 */
class GitServiceHelper
{
    /**
     * @param int $id
     * @return GitTypes
     */
    public function resolveGitProvider(int $id): GitTypes
    {
        return GitTypes::findOrFail($id);
    }

    /**
     * @param string $provider
     * @param string $url
     * @return string
     */
    public function getRepoName(string $provider, string $url): string
    {
        $url = str_replace('/src/master/', '', $url);

        return str_replace('https://' . $provider . '.' . $this->providerExtension($provider) . '/', '', $url);
    }

    /**
     * @param string $repoName
     * @return array
     */
    public function getRepoSlug(string $repoName): array
    {
        return explode('/', $repoName);
    }

    /**
     * @param string $provider
     * @return string
     */
    public function providerExtension(string $provider): string
    {
        switch ($provider) {
            case 'github':
                return 'com';

                break;
            case 'bitbucket':
                return 'org';

                break;
        }
    }
}
