<?php

namespace App\Services\LogService\Interfaces;

/**
 * Interface LogServiceInterface
 * @package App\Services\LogService
 */
interface LogServiceInterface
{
    /**
     * @return mixed
     */
    public function getModel();

    /**
     * @param $model
     * @return $this
     */
    public function setModel($model);

    /**
     * @return mixed
     */
    public function getModelId();

    /**
     * @param $modelId
     * @return $this
     */
    public function setModelId($modelId);

    /**
     * @return mixed
     */
    public function getNewValue();

    /**
     * @param $newValue
     * @return $this
     */
    public function setNewValue($newValue);

    /**
     * @return mixed
     */
    public function getOldValue();

    /**
     * @param $oldValue
     * @return $this
     */
    public function setOldValue($oldValue);

    /**
     * @return mixed
     */
    public function getAction();

    /**
     * @param $action
     * @return $this
     */
    public function setAction($action);

    /**
     * @return mixed
     */
    public function getUserId();

    /**
     * @param $userId
     * @return $this
     */
    public function setUserId($userId);

    /**
     * @return array
     */
    public function getData();
}
