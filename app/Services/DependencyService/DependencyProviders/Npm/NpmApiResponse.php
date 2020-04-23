<?php

namespace App\Services\DependencyService\DependencyProviders\Npm;

use App\Services\DependencyService\DependencyProviders\DependencyApiInterfaces\DependencyApiResponse;
use Psr\Http\Message\ResponseInterface;

class NpmApiResponse implements DependencyApiResponse
{
    /** @var mixed $response */
    protected $response;

    /** @var bool $success */
    protected $success = true;

    /** @var int $statusCode */
    protected $statusCode = 200;

    /**
     * NpmApiResponse constructor.
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
    public function isSuccessful(): bool
    {
        return isset($this->response->error) ? false : true;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
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
     * @return string
     */
    public function getLatestVersion(): string
    {
        return $this->response->{'dist-tags'}->latest;
    }
}
