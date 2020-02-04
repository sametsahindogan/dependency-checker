<?php

namespace App\Services\LogService;

use App\Services\LogService\Interfaces\LogServiceInterface;
use App\Services\LogService\Interfaces\Renderable;

/**
 * Class LogDecorator
 * @package App\Services\LogService
 */
abstract class LogDecorator implements Renderable
{

    /** @var LogServiceInterface $service */
    protected $service;

    /**
     * LogDecorator constructor.
     * @param LogServiceInterface $logService
     */
    public function __construct(LogServiceInterface $logService)
    {
        $this->service = $logService;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->service->getData();
    }
}
