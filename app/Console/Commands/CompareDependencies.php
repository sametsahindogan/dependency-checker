<?php

namespace App\Console\Commands;

use App\Services\CompareService\PackageComparator;
use App\Services\DependencyService\DependencyService;
use App\Services\GitService\GitService;
use Illuminate\Console\Command;

/**
 * Class CompareDependencies
 * @package App\Console\Commands
 */
class CompareDependencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-dependencies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all dependencies from database.';

    /** @var PackageComparator $packageComparator */
    protected $packageComparator;

    /** @var GitService $gitService */
    protected $gitService;

    /** @var DependencyService $dependencyService */
    protected $dependencyService;

    /**
     * Create a new command instance.
     *
     * @param PackageComparator $packageComparator
     * @param GitService $gitService
     * @param DependencyService $dependencyService
     */
    public function __construct(PackageComparator $packageComparator, GitService $gitService, DependencyService $dependencyService)
    {
        parent::__construct();

        $this->packageComparator = $packageComparator;
        $this->gitService = $gitService;
        $this->dependencyService = $dependencyService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): bool
    {
        return $this->refreshAllRepositories();
    }

    /**
     * @return bool
     */
    public function refreshAllRepositories(): bool
    {
        $this->dependencyService->deleteAllDependencies();

        $repositories = $this->gitService->gitRepository->getAllRepositoriesWithGitProvidersAndEmails();

        foreach ($repositories['datas'] as $repository) {
            $this->gitService->refreshDependencies($repository);
        }

        $this->packageComparator->run();

        return true;
    }
}
