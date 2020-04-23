<?php

namespace App\Services\GitService\GitProviders\Bitbucket;

use App\Services\GitService\GitProviders\GitApiInterfaces\GitApiResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Class BitbucketApiResponse
 * @package App\Services\GitService\GitProviders\Bitbucket
 */
class BitbucketApiResponse implements GitApiResponse
{
    /** @var mixed $response */
    protected $response;

    /** @var bool $success */
    protected $success = true;

    /** @var int $statusCode  */
    protected $statusCode = 200;

    /**
     * BitbucketApiResponse constructor.
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
        return !(isset($this->response->type) && $this->response->type === 'error');
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->response->error->message;
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
        return $this->response->full_name;
    }

    /**
     * @return mixed
     */
    public function getFileContent()
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getEncodeType(): string
    {
        return '';
    }
}
