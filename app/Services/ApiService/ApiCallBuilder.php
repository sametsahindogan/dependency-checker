<?php

namespace App\Services\ApiService;

use App\Services\ApiService\Interfaces\ApiCallBuilderInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ApiCallBuilder
 * @package App\Services\ApiService
 */
class ApiCallBuilder implements ApiCallBuilderInterface
{
    /** @var string $api_url */
    protected $apiUrl;

    /** @var string $method */
    protected $method;

    /** @var string $uri */
    protected $uri;

    /** @var string $querystring */
    protected $queryString;

    /** @var Request $request */
    protected $request;

    /** @var Client $httpClient */
    protected $httpClient;

    /**
     * ApiCallBuilder constructor.
     * @param $uri
     * @param $apiUrl
     * @param string $method
     */
    public function __construct($uri, $apiUrl)
    {
        $this->apiUrl = $apiUrl;
        $this->httpClient = new Client(['http_errors' => false]);
        $this->uri = $uri;
    }

    /**
     * @param String $method
     * @return $this
     */
    public function method(String $method): self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param String $uri
     * @return $this
     */
    public function uri(String $uri): self
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @param string $queryString
     * @return $this
     */
    public function queryString(string $queryString): self
    {
        $this->queryString = $queryString;
        return $this;
    }

    /**
     * @return ResponseInterface
     */
    public function call(): ResponseInterface
    {
        return $this->httpClient->get( $this->apiUrl . $this->uri . $this->queryString);
    }

}
