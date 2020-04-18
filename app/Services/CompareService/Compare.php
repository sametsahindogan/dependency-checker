<?php

namespace App\Services\CompareService;

use App\Jobs\NotificationMailJob;
use App\Models\Dependency;
use App\Models\Repository;
use App\Services\DependencyService\DependencyFactory;
use App\Services\DependencyService\DependencyResponse;
use Composer\Semver\Comparator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Compare
 * @package App\Services\CompareService
 */
class Compare implements CompareInterface
{
    /**
     * @var Model $model
     */
    protected $model;

    /**
     * @var bool $checkAll
     */
    protected $checkAll = false;

    /**
     * @var string $modelId
     */
    protected $modelId = null;

    /**
     * @var string $status
     */
    protected $status = Repository::STATUS_CHECKING;
    /**
     * @var array $escapeChar
     */
    protected $escapeChar = ['v', '^', '-', '/', '*', '~'];

    /** @var array $mailList */
    protected $mailList = [];

    /**
     * @var array $types
     */
    protected $types = [
        Dependency::TYPE_PACKAGIST => 'packagist',
        Dependency::TYPE_NPM => 'npm'
    ];

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param Model $model
     * @return $this
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return bool
     */
    public function getCheckAll()
    {
        return $this->checkAll;
    }

    /**
     * @param bool $checkAll
     * @return $this
     */
    public function setCheckAll(bool $checkAll): self
    {
        $this->checkAll = $checkAll;
        return $this;

    }

    /**
     * @return string
     */
    public function getModelId()
    {
        return $this->modelId;
    }

    /**
     * @param string $modelId
     * @return $this
     */
    public function setModelId(string $modelId): self
    {
        $this->modelId = $modelId;
        return $this;

    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;

    }

    /**
     * @return array
     */
    public function getEscapeChar()
    {
        return $this->escapeChar;
    }

    /**
     * @param $escapeChar
     * @return $this
     */
    public function setEscapeChar($escapeChar): self
    {
        $this->escapeChar = $escapeChar;
        return $this;

    }

    /**
     * @return array
     */
    public function getMailList()
    {
        return $this->mailList;
    }

    /**
     * @param Collection $emails
     * @return $this
     */
    public function setMailList(Collection $emails)
    {
        foreach ($emails as $email) {
            $this->mailList[] = $email->title;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function execute()
    {
        $queryBuilder = $this->model->with('dependencies', 'emails');

        if ($this->getCheckAll()) {
            $repositories = $queryBuilder->get();

            foreach ($repositories as $repository) {

                $this->setMailList($repository->emails);

                $this->compare($repository);
            }
        } else {
            $repository = $queryBuilder->find($this->getModelId());

            $this->setMailList($repository->emails);

            $this->compare($repository);

        }

        return true;
    }

    /**
     * @param Model $repository
     */
    protected function compare(Model $repository)
    {
        $repository->status = $this->getStatus();
        $repository->save();
        foreach ($repository->dependencies as $dependency) {
            $this->compareByType($dependency);
        }
        $repository->status = $this->getStatus() == Repository::STATUS_CHECKING
            ? Repository::STATUS_UPTODATE : $this->getStatus();

        $repository->checked_at = now();
        $repository->save();
    }

    /**
     * @param Model $dependency
     */
    protected function compareByType(Model $dependency)
    {
        /** @var string $class */
        $class = $this->types[$dependency->type_id];

        /** @var DependencyResponse $response */
        $response = (new DependencyFactory())->make($class)->getPackage($dependency->title);

        $latest = str_replace($this->getEscapeChar(), '', $response->getLatestVersion());

        /** @var bool $value */
        $value = Comparator::greaterThanOrEqualTo($dependency->current_version, $latest);
        $dependency->latest_version = $latest;
        if (!$value) {
            $this->setStatus(Repository::STATUS_OUTDATED);
            $dependency->status = Dependency::STATUS_OUTDATED;
            $text = 'The dependency ' . $dependency->title . ' of your project at ' . $dependency->repository->repo_url . ' is outdated.';
            $this->sendMail($text);

        } else {
            $dependency->status = Dependency::STATUS_UPTODATE;
        }

        $dependency->save();
    }

    /**
     * @param $text
     */
    protected function sendMail($text)
    {
        dispatch((new NotificationMailJob($this->getMailList(), $text)));
    }
}
