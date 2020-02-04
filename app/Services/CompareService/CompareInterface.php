<?php

namespace App\Services\CompareService;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface CompareInterface
 * @package App\Services\CompareService
 */
interface CompareInterface
{
    /**
     * @return mixed
     */
    public function getModel();

    /**
     * @param Model $model
     * @return mixed
     */
    public function setModel(Model $model);

    /**
     * @return mixed
     */
    public function getCheckAll();

    /**
     * @param bool $checkAll
     * @return $this
     */
    public function setCheckAll(bool $checkAll);

    /**
     * @return mixed
     */
    public function getModelId();

    /**
     * @param string $modelId
     * @return $this
     */
    public function setModelId(string $modelId);

    /**
     * @return mixed
     */
    public function getStatus();

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status);

    /**
     * @return mixed
     */
    public function getEscapeChar();

    /**
     * @param $escapeChar
     * @return $this
     */
    public function setEscapeChar($escapeChar);

    /**
     * @return mixed
     */
    public function getMailList();

    /**
     * @param Collection $emails
     * @return mixed
     */
    public function setMailList(Collection $emails);

    /**
     * @return mixed
     */
    public function execute();
}
