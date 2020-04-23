<?php

namespace App\Services\JsonResponseService;

/**
 * Interface ResponseBuilderInterface
 * @package App\Services\JsonResponseService
 */
interface ResponseBuilderInterface
{
    /**
     * @param bool $result
     * @return $this
     */
    public function result(bool $result);

    /**
     * @param string $message
     * @return $this
     */
    public function message(string $message);

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
