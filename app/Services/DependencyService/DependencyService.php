<?php

namespace App\Services\DependencyService;

use App\Repositories\DependencyRepository;
use App\Repositories\GitRepository;
use App\Services\DependencyService\Output\OutputInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class DependencyService
 * @package App\Services\DependencyService
 */
class DependencyService
{
    /** @var GitRepository $gitRepository */
    public $gitRepository;

    /** @var DependencyRepository $dependencyRepository */
    public $dependencyRepository;

    /**
     * DependencyService constructor.
     * @param GitRepository $gitRepository
     * @param DependencyRepository $dependencyRepository
     */
    public function __construct(GitRepository $gitRepository, DependencyRepository $dependencyRepository)
    {
        $this->gitRepository = $gitRepository;
        $this->dependencyRepository = $dependencyRepository;
    }

    /**
     * @param string $repoSlug
     * @param string $projectSlug
     * @param OutputInterface $output
     * @return mixed
     */
    public function getRepositoryDependencies(string $repoSlug, string $projectSlug, OutputInterface $output)
    {
        return $output->render($this->gitRepository->getRepositoryDependencies($repoSlug, $projectSlug));
    }

    /**
     * @return Builder
     */
    public function deleteAllDependencies(): Builder
    {
        return $this->dependencyRepository->deleteAllDependencies();
    }
}
