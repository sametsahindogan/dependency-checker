<?php

namespace App\Services\ApiService\Interfaces;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface ApiCallBuilderInterface
 * @package App\Services\ApiService\Interfaces
 */
interface ApiCallBuilderInterface
{
    /**
     * @param String $method
     * @return mixed
     */
    public function method(String $method);

    /**
     * @param String $uri
     * @return mixed
     */
    public function uri(String $uri);

    /**
     * @param string $queryString
     * @return $this
     */
    public function queryString(string $queryString);

    /**
     * @return ResponseInterface
     */
    public function call();

}
