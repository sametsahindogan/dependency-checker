<?php


namespace App\Services\GitService\Bitbucket;

use App\Services\GitService\GitResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Class BitbucketApiResponse
 * @package App\Services\GitService\Bitbucket
 */
class BitbucketApiResponse implements GitResponse
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
     * @return mixed
     */
    public function isSuccessful()
    {
        return isset($this->response->type) && $this->response->type === 'error' ? false : true;
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
        return $this->response->error->message;
    }

    /**
     * @return mixed
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
    public function getRepoId()
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
     * @return mixed
     */
    public function getEncodeType()
    {
        return null;
    }
}
