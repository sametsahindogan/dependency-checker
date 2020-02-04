<?php

namespace App\Services\DependencyService\Packagist;

use App\Services\DependencyService\DependencyResponse;
use DOMDocument;
use Psr\Http\Message\ResponseInterface;

/**
 * Class PackagistApiResponse
 * @package App\Services\DependencyService\Packagist
 */
class PackagistApiResponse implements DependencyResponse
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

        /** @var DOMDocument $dom */
        $dom = new DOMDocument();

        @$dom->loadHTML($response->getBody()->getContents());

        $spans = $dom->getElementsByTagName('span');

        $this->response = $spans;

    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        foreach ($this->response as $span) {
            if ($span->getAttribute('class') == 'version-number') return true;
        }

        return false;
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
        foreach ($this->response as $span) {
            if ($span->getAttribute('class') == 'version-number') {
                return $span->nodeValue;
            }
        }
    }
}
