<?php

namespace App\Observers;

use App\Services\LogService\Interfaces\LogServiceInterface;
use App\Services\LogService\RenderDatabase;
use Illuminate\Database\Eloquent\Model;

class BaseObserver
{
    /**
     * @var LogServiceInterface $log
     */
    public $log;

    /**
     * BaseObserver constructor.
     * @param LogServiceInterface $logService
     */
    public function __construct(LogServiceInterface $logService)
    {
        $this->log = $logService;
    }

    /**
     * Handle the Model "created" event.
     * @param Model $model
     * @return void
     */
    public function created(Model $model)
    {
        (new RenderDatabase($this->log->setUserId(authed()->id)
            ->setModel($model->getTable())
            ->setModelId($model->id)
            ->setNewValue($model->getAttributes())
            ->setAction(__FUNCTION__))
        )->render();
    }
}
