<?php

namespace App\Services\DependencyService\Npm;

use App\Services\DependencyService\DependencyResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Class NpmApiResponse
 * @package App\Services\DependencyService\Npm
 */
class NpmApiResponse implements DependencyResponse
{
    /** @var mixed $response */
    protected $response;

    /** @var bool $success */
    protected $success = true;

    /** @var int $statusCode */
    protected $statusCode = 200;

    /**
     * Response constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->statusCode = $response->getStatusCode();

        $this->response = json_decode($response->getBody()->getContents());
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return isset($this->response->error) ? false : true;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return mixed
     */
    public function getDecoded()
    {
        return $this->response;
    }

    /**
     * @return mixed
     */
    public function getLatestVersion()
    {
        return $this->response->{'dist-tags'}->latest;
    }
}
