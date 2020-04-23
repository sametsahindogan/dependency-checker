<?php


namespace App\Services\GitService\Adapter;

/**
 * Interface GitAdapterInterface
 * @package App\Services\GitService\Adapter
 */
interface GitAdapterInterface
{

    /**
     * @param string $data
     * @return GitAdapterInterface
     */
    public function setRepo(string $data): GitAdapterInterface;

    /**
     * @return array
     */
    public function call(): array;
}
