<?php

namespace App\Services\CompareService;

use App\Jobs\NotificationMailJob;
use App\Models\Dependencies\Dependency;
use App\Models\Repositories\Repository;
use App\Repositories\DependencyRepository;
use App\Repositories\GitRepository;
use App\Services\DependencyService\DependencyProviders\DependencyApiInterfaces\DependencyApiRequest;
use App\Services\DependencyService\DependencyProviders\DependencyApiInterfaces\DependencyApiResponse;
use App\Services\DependencyService\DependencyProviders\DependencyProviderFactory;
use Composer\Semver\Comparator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PackageComparator
 * @package App\Services\CompareService
 */
class PackageComparator
{

    /** @var GitRepository $gitRepository */
    protected $gitRepository;

    /** @var DependencyRepository $dependencyRepository */
    protected $dependencyRepository;

    /** @var DependencyProviderFactory $dependencyProviderFactory */
    protected $dependencyProviderFactory;

    /** @var bool $checkOnly */
    protected $checkOnly = false;

    /** @var string $repositoryStatus */
    protected $repositoryStatus = Repository::STATUS_CHECKING;

    /** @var array $escapeChar */
    protected $escapeChar = ['v', '^', '-', '/', '*', '~'];

    /** @var array $mailList */
    protected $mailList = [];

    /** @var array $types */
    protected $types = [
        Dependency::TYPE_PACKAGIST => 'packagist',
        Dependency::TYPE_NPM => 'npm'
    ];

    /**
     * PackageComparator constructor.
     * @param GitRepository $gitRepository
     * @param DependencyRepository $dependencyRepository
     * @param DependencyProviderFactory $dependencyProviderFactory
     */
    public function __construct(GitRepository $gitRepository, DependencyRepository $dependencyRepository, DependencyProviderFactory $dependencyProviderFactory)
    {
        $this->gitRepository = $gitRepository;
        $this->dependencyRepository = $dependencyRepository;
        $this->dependencyProviderFactory = $dependencyProviderFactory;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function checkOnly(int $id): self
    {
        $this->checkOnly = $id;

        return $this;

    }

    /**
     * @return bool
     */
    public function run(): bool
    {
        if (!$this->checkOnly) {
            $repositories = $this->gitRepository->getAllRepositoriesWithDependenciesAndEmails();

            foreach ($repositories['datas'] as $repository) {
                $this->setMailList($repository->emails)->compare($repository);
            }
        } else {
            $repository = $this->gitRepository->getByIdWithDependenciesAndEmails($this->checkOnly);

            $this->setMailList($repository->emails)->compare($repository);
        }

        return true;
    }

    /**
     * @param Collection $emails
     * @return $this
     */
    protected function setMailList(Collection $emails): self
    {
        foreach ($emails as $email) {
            $this->mailList[] = $email->title;
        }

        return $this;
    }

    /**
     * @param Repository $repository
     * @return bool
     */
    protected function compare(Repository $repository): bool
    {
        $this->gitRepository->setStatusChecking($repository);

        $dependencies = $repository->dependencies;

        if ($dependencies->isEmpty()) {

            $this->gitRepository->setStatusError($repository);

            return false;
        }

        foreach ($dependencies as $dependency) {

            $this->compareByType($repository, $dependency);

        }

        $this->handleRepositoryStatus($repository);

        return true;
    }

    /**
     * @param Repository $repository
     * @return bool
     */
    protected function handleRepositoryStatus(Repository $repository): bool
    {
        /** If any outdated package is found, the repositoryStatus value has changed. */
        if ($this->repositoryStatus === Repository::STATUS_CHECKING) {

            return $this->gitRepository->setStatusUptodate($repository);

        }

        return $this->gitRepository->setStatusOutdated($repository);
    }

    /**
     * @param Repository $repository
     * @param Dependency $dependency
     * @return bool
     */
    protected function compareByType(Repository $repository, Dependency $dependency): bool
    {
        /** @var DependencyApiRequest $provider */
        $provider = $this->dependencyProviderFactory->make($this->types[$dependency->type_id]);

        /** @var DependencyApiResponse $response */
        $response = $provider->getPackage($dependency->title);

        if ($response->isSuccessful()) {

            $latest = str_replace($this->escapeChar, '', $response->getLatestVersion());

            /** @var bool $value */
            $value = Comparator::greaterThanOrEqualTo($dependency->current_version, $latest);

            $dependency->latest_version = $latest;

            if (!$value) {

                $this->repositoryStatus = Repository::STATUS_OUTDATED;

                $this->dependencyRepository->setStatusOutdated($dependency);

                $text = 'The dependency ' . $dependency->title . ' of your project at ' . $repository->repo_url . ' is outdated.';

                $this->sendMail($text);

            } else {
                $this->dependencyRepository->setStatusUptodate($dependency);
            }

            return true;
        }

        return false;
    }

    /**
     * @param $text
     */
    protected function sendMail($text)
    {
        dispatch((new NotificationMailJob($this->mailList, $text)));
    }
}
