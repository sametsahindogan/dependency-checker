<?php


namespace App\Services\GitService\Output;

/**
 * Interface OutputInterface
 * @package App\Services\GitService\Output
 */
interface OutputInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function render($data);
}
