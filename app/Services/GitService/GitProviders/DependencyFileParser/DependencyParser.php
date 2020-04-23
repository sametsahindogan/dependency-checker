<?php

namespace App\Services\GitService\GitProviders\DependencyFileParser;

use App\Services\GitService\GitProviders\GitApiInterfaces\GitApiResponse;

/**
 * Interface DependencyParser
 * @package App\Services\GitService\GitProviders\DependencyFileParser
 */
interface DependencyParser
{
    /**
     * @return array
     */
    public function getDependencies(): array;

    /**
     * @param GitApiResponse $response
     * @return self
     */
    public function execute(GitApiResponse $response): DependencyParser;

    /**
     * @param GitApiResponse $response
     * @param string $key
     * @return mixed
     */
    public function checkKey(GitApiResponse $response, string $key): array;

    /**
     * @param string $version
     * @return string
     */
    public function formatVersion(string $version): string;

    /**
     * @param GitApiResponse $response
     * @return mixed
     */
    public function getContent(GitApiResponse $response): array;

    /**
     * @return bool
     */
    public function setDependencies(): bool;
}
