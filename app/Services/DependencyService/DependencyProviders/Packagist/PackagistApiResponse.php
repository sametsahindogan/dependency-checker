<?php

namespace App\Services\DependencyService\DependencyProviders\Packagist;

use App\Services\DependencyService\DependencyProviders\DependencyApiInterfaces\DependencyApiResponse;
use DOMDocument;
use Psr\Http\Message\ResponseInterface;

class PackagistApiResponse implements DependencyApiResponse
{
    /** @var mixed $response */
    protected $response;

    /** @var bool $success */
    protected $success = true;

    /** @var int $statusCode */
    protected $statusCode = 200;

    /**
     * PackagistApiResponse constructor.
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
    public function isSuccessful(): bool
    {
        foreach ($this->response as $span) {
            if ($span->getAttribute('class') == 'version-number') return true;
        }

        return false;
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
        foreach ($this->response as $span) {
            if ($span->getAttribute('class') == 'version-number') {
                return $span->nodeValue;
            }
        }

        return '';
    }
}
