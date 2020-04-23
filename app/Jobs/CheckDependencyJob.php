<?php

namespace App\Jobs;

use App\Services\CompareService\PackageComparator;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class CheckDependencyJob
 * @package App\Jobs
 */
class CheckDependencyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string $repositoryId
     */
    private $repositoryId;

    /**
     * CheckDependency constructor.
     * @param string $repositoryId
     */
    public function __construct(string $repositoryId)
    {
        $this->repositoryId = $repositoryId;
    }

    /**
     * Execute the job.
     *
     * @param PackageComparator $packageComparator
     * @return void
     */
    public function handle(PackageComparator $packageComparator)
    {
        $packageComparator->checkOnly($this->repositoryId)->run();

        return;
    }
}
