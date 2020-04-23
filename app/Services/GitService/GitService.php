<?php

namespace App\Services\GitService;

use App\Jobs\NotificationMailJob;
use App\Models\Repositories\Repository;
use App\Repositories\GitRepository;
use App\Services\GitService\GitProviders\GitApiInterfaces\GitApiRequest;
use App\Services\GitService\GitProviders\GitProviderFactory;
use App\Services\GitService\Helper\GitServiceHelper;
use App\Services\GitService\Output\OutputInterface;
use Exception;

/**
 * Class GitService
 * @package App\Services\GitService
 */
class GitService
{
    /** @var GitRepository $gitRepository */
    public $gitRepository;

    /** @var GitProviderFactory $gitFactory */
    public $gitProviderFactory;

    /** @var GitServiceHelper $serviceHelper */
    public $serviceHelper;

    /**
     * GitService constructor.
     * @param GitRepository $gitRepository
     * @param GitProviderFactory $gitProviderFactory
     * @param GitServiceHelper $serviceHelper
     */
    public function __construct(GitRepository $gitRepository, GitProviderFactory $gitProviderFactory, GitServiceHelper $serviceHelper)
    {
        $this->gitRepository = $gitRepository;
        $this->gitProviderFactory = $gitProviderFactory;
        $this->serviceHelper = $serviceHelper;
    }

    /**
     * @param string $sort
     * @param string $sortType
     * @param int $offset
     * @param int $limit
     * @param OutputInterface $output
     * @return mixed
     */
    public function getAllRepositoriesWithGitProviders(string $sort, string $sortType, int $offset, int $limit, OutputInterface $output)
    {
        return $output->render($this->gitRepository->getAllRepositoriesWithGitProviders($sort, $sortType, $offset, $limit));
    }


    /**
     * @param int $typeId
     * @param string repo_url
     * @param array $emails
     * @return Repository
     * @throws Exception
     */
    public function createRepository(int $typeId, string $repoUrl, array $emails): Repository
    {
        $gitProvider = $this->serviceHelper->resolveGitProvider($typeId);

        $repoName = $this->serviceHelper->getRepoName($gitProvider->title, $repoUrl);

        $repoSlug = $this->serviceHelper->getRepoSlug($repoName);

        if ($this->isItAlreadySaved($repoSlug[0], $repoSlug[1])) {
            throw new Exception('This repository is already saved.');
        }

        /** @var GitApiRequest $provider */
        $provider = $this->gitProviderFactory->make($gitProvider->title);

        $repo = $this->retrieveGitRepository($provider, $repoName);

        return $this->gitRepository->create($typeId, $repoUrl, $repo['repo_id'], $repo['dependencies'], $repoSlug[0], $repoSlug[1], $emails);
    }

    /**
     * @param GitApiRequest $provider
     * @param string $repoName
     * @return array
     * @throws Exception
     */
    protected function retrieveGitRepository(GitApiRequest $provider, string $repoName): array
    {
        if (!$provider->isValidRepository($repoName)) {
            throw new Exception('Repository not found.');
        }

        $repository = $provider->getRepoWithDependencies();

        if (empty($repository['dependencies'])) {
            throw new Exception('No dependency found in this repository.');
        }

        return $repository;
    }

    /**
     * @param string $repoSlug
     * @param string $projectSlug
     * @return bool
     */
    protected function isItAlreadySaved(string $repoSlug, string $projectSlug): bool
    {
        return $this->gitRepository->getBySlug($repoSlug, $projectSlug) ? true : false;
    }

    /**
     * @param Repository $repository
     * @return bool
     */
    public function refreshDependencies(Repository $repository): bool
    {
        $repositorySlug = $repository->repo_slug . '/' . $repository->project_slug;

        try {
            $dependencies = $this->retrieveGitRepository($this->gitProviderFactory->make($repository->gitProvider->title), $repositorySlug);

            $this->gitRepository->createDependencies($repository, $dependencies['dependencies']);

        } catch (Exception $exception) {

            $this->gitRepository->setStatusError($repository);

            $text = 'An error occurred while checking the repo (' . $repositorySlug . ') : ' . $exception->getMessage();

            dispatch((new NotificationMailJob($repository->emails->pluck('title')->toArray(), $text)));
        }

        return true;
    }


}
