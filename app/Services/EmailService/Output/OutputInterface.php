<?php


namespace App\Services\EmailService\Output;

/**
 * Interface OutputInterface
 * @package App\Services\EmailService\Output
 */
interface OutputInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function render($data);
}
