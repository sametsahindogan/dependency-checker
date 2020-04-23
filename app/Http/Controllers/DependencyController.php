<?php

namespace App\Http\Controllers;

use App\Services\DependencyService\Output\JsonOutput;
use App\Services\DependencyService\DependencyService;

/**
 * Class DependencyController
 * @package App\Http\Controllers
 */
class DependencyController extends Controller
{
    /**
     * @var DependencyService $service
     */
    private $service;

    /**
     * DependencyController constructor.
     * @param DependencyService $service
     */
    public function __construct(DependencyService $service)
    {
        $this->service = $service;
    }

    /**
     * @param $repoSlug
     * @param $projectSlug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($repoSlug, $projectSlug)
    {
        return view('dependency.list', ['repo' => $repoSlug, 'project' => $projectSlug]);
    }

    /**
     * @param $repoSlug
     * @param $projectSlug
     * @return mixed
     */
    public function get($repoSlug, $projectSlug)
    {
        return $this->service->getRepositoryDependencies($repoSlug, $projectSlug, new JsonOutput());
    }
}
