<?php

namespace App\Services\GitService\Github;

use App\Services\GitService\GitResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Class GithubApiResponse
 * @package App\Services\GitService\Github
 */
class GithubApiResponse implements GitResponse
{
    /** @var mixed $response */
    protected $response;

    /** @var bool $success */
    protected $success = true;

    /** @var int $statusCode */
    protected $statusCode = 200;

    /**
     * Response constructor.
     * @param \Psr\Http\Message\ResponseInterface $response
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
        return isset($this->response->message) ? false : true;
    }

    /**
     * @return mixed
     */
    public function getData()
    {

        return $this->response->data[0];
    }

    /**
     * @return mixed
     */
    public function getError()
    {

        return $this->response->error[0];
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
    public function getMessage()
    {
        return $this->response->message;
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
    public function getRepoId()
    {
        return $this->response->id;
    }

    /**
     * @return mixed
     */
    public function getFileContent()
    {
        return $this->response->content;
    }

    /**
     * @return mixed
     */
    public function getEncodeType()
    {
        return $this->response->encoding;
    }
}
