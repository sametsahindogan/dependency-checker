<?php

namespace App\Jobs;

use App\Models\Repository;
use App\Services\CompareService\CompareInterface;
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
     * @return void
     */
    public function handle(CompareInterface $compare, Repository $repositoryModel)
    {
        $compare->setCheckAll(false)
            ->setModel($repositoryModel)
            ->setModelId($this->repositoryId)
            ->execute();
    }
}
