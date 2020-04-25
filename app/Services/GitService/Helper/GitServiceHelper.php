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
    public static function resolveGitProvider(int $id): GitTypes
    {
        return GitTypes::findOrFail($id);
    }

    /**
     * @param string $provider
     * @param string $url
     * @return string
     */
    public static function getRepoName(string $provider, string $url): string
    {
        $url = str_replace('/src/master/', '', $url);

        return str_replace('https://' . $provider . '.' . self::providerExtension($provider) . '/', '', $url);
    }

    /**
     * @param string $repoName
     * @return array
     */
    public static function getRepoSlug(string $repoName): array
    {
        return explode('/', $repoName);
    }

    /**
     * @param string $provider
     * @return string
     */
    public static function providerExtension(string $provider): string
    {
        switch ($provider) {
            case 'github':
                return 'com';

                break;
            case 'bitbucket':
                return 'org';

                break;
        }

        return '';
    }
}
