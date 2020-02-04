<?php

namespace App\Console\Commands;

use App\Jobs\NotificationMailJob;
use App\Models\Repository;
use App\Services\CompareService\CompareInterface;
use App\Services\GitService\GitFactory;
use App\Services\GitService\GitResponse;
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

    /** @var CompareInterface $compare */
    protected $compare;

    /** @var GitFactory $gitFactory */
    protected $gitFactory;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CompareInterface $compare, GitFactory $gitFactory)
    {
        parent::__construct();

        $this->compare = $compare;
        $this->gitFactory = $gitFactory;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var Repository $repositories */
        $repositories = Repository::with('dependencies', 'emails')->get();

        foreach ($repositories as $repository){

            $repository->dependencies()->delete();

            /** @var GitResponse|array $repo */
            $repo = $this->gitFactory->make($repository->gitProvider->title)->getRepoWithDependencies($repository->repo_slug.'/'.$repository->project_slug);

            if( ($repo instanceof GitResponse) || (empty($repo['dependencies']))){

                $repository->status = Repository::STATUS_ERROR;
                $repository->save();

                $emails = [];
                foreach ($repository->emails as $email){
                    $emails[] = $email->title;
                }
                if(!empty($emails))
                {
                    $text = 'The dependencies of your project at '.$repository->repo_url.' could not be checked.';
                    dispatch( (new NotificationMailJob($emails, $text)) );
                }

                return;
            }

            foreach ($repo['dependencies'] as $dependency) {
                $repository->dependencies()->create($dependency);
            }
            $repository->status = Repository::STATUS_CHECKING;
            $repository->save();
        }

        $this->compare->setCheckAll(true)->setModel(new Repository())->execute();

        return;
    }
}
