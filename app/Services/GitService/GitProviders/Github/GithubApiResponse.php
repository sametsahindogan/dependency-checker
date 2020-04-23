<?php

namespace App\Services\GitService\GitProviders\Github;

use App\Services\GitService\GitProviders\GitApiInterfaces\GitApiResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Class GithubApiResponse
 * @package App\Services\GitService\GitProviders\Github
 */
class GithubApiResponse implements GitApiResponse
{
    /** @var mixed $response */
    protected $response;

    /** @var bool $success */
    protected $success = true;

    /** @var int $statusCode */
    protected $statusCode = 200;

    /**
     * GithubApiResponse constructor.
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
        return !isset($this->response->message);
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->response->error[0];
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getRepoId(): string
    {
        return (string)$this->response->id;
    }

    /**
     * @return mixed
     */
    public function getFileContent()
    {
        return $this->response->content;
    }

    /**
     * @return string
     */
    public function getEncodeType(): string
    {
        return $this->response->encoding;
    }
}
