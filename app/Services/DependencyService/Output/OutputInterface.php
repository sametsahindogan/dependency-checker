<?php


namespace App\Services\DependencyService\Output;

/**
 * Interface OutputInterface
 * @package App\Services\DependencyService\Output
 */
interface OutputInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function render($data);
}
