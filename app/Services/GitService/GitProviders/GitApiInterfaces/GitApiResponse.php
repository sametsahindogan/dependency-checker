<?php

namespace App\Services\GitService\GitProviders\GitApiInterfaces;

/**
 * Interface GitApiResponse
 * @package App\Services\GitService\GitProviders\GitApiInterfaces
 */
interface GitApiResponse
{
    /**
     * @return bool
     */
    public function isSuccessful(): bool;

    /**
     * @return string
     */
    public function getError(): string;

    /**
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * @return string
     */
    public function getRepoId(): string;

    /**
     * @return mixed
     */
    public function getFileContent();

    /**
     * @return string
     */
    public function getEncodeType(): string;

}
