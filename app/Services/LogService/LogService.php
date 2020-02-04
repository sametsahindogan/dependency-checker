<?php

namespace App\Services\LogService;

use App\Services\LogService\Interfaces\LogServiceInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LogService
 * @package App\Services\LogService
 */
class LogService implements LogServiceInterface
{

    /** @var integer $user_id */
    protected $userId;

    /** @var Model $model */
    protected $model;

    /** @var integer $modelId */
    protected $modelId;

    /** @var mixed $newValue */
    protected $newValue;

    /** @var mixed $oldValue */
    protected $oldValue;

    /** @var string $action */
    protected $action;

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getModelId()
    {
        return $this->modelId;
    }

    /**
     * @param mixed $modelId
     */
    public function setModelId($modelId): self
    {
        $this->modelId = $modelId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNewValue()
    {
        return $this->newValue;
    }

    /**
     * @param mixed $newValue
     */
    public function setNewValue($newValue = null): self
    {
        $this->newValue = json_encode($newValue);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOldValue()
    {
        return $this->oldValue;
    }

    /**
     * @param mixed $oldValue
     */
    public function setOldValue($oldValue = null): self
    {
        $this->oldValue = json_encode($oldValue);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action): self
    {
        $this->action = $action;

        return $this;
    }

    /**~
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'user_id' => $this->getUserId(),
            'model' => $this->getModel(),
            'model_id' => $this->getModelId(),
            'new_value' => $this->getNewValue(),
            'old_value' => $this->getOldValue(),
            'action' => $this->getAction()
        ];
    }

}
