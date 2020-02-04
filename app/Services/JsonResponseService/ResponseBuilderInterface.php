<?php

namespace App\Services\JsonResponseService;

/**
 * Interface ResponseBuilderInterface
 * @package App\Services\ResponseService
 */
interface ResponseBuilderInterface
{
    /**
     * @param bool $result
     * @return $this
     */
    public function result(bool $result);

    /**
     * @param String $message
     * @return $this
     */
    public function message(String $message);

    /**
     * @param array $fields
     * @return $this
     */
    public function fields(array $fields);

    /**
     * @return array
     */
    public function build();
}
