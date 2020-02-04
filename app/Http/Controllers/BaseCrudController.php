<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Interfaces\BaseCrudInterface;
use App\Models\Repository;
use App\Services\JsonResponseService\ResponseBuilderInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;

/**
 * Class BaseCrudController
 * @package App\Http\Controllers
 */
abstract class BaseCrudController extends Controller implements BaseCrudInterface
{
    /** @var Model $model */
    protected $model;

    /** @var ResponseBuilderInterface $response */
    protected $response;

    /**
     * @param string $id
     * @param Model $model
     * @return mixed
     */
    public function getRecordById(string $id)
    {
        return $this->model::findOrFail($id);
    }

    /**
     * @param array $slug
     * @param Model $model
     * @return mixed
     */
    public function getRecordBySlug(array $slug)
    {
        return $this->model::where($slug)->first();
    }

    /**
     * @param MessageBag $errors
     * @return JsonResponse
     */
    public function getErrorResponse(MessageBag $errors)
    {
        $response = [];
        $response['message'] = '<span class="validation-error-message">';
        foreach ($errors->messages() as $field => $message) {
            $response['fields'][$field] = '<span class="validation-error-field">' . $message[0] . '</span>';
            $response['message'] .= $response['fields'][$field];
        }
        $response['message'] .= '</span>';

        return response()->json($this->response
            ->result(false)
            ->message($response['message'])
            ->fields($response['fields'])
            ->build()
        );
    }

    /**
     * @param string $status
     * @return string
     */
    public function getStatus(string $status)
    {
        switch ($status) {
            case Repository::STATUS_OUTDATED:
                $status = '<span class="label label-warning">' . strtoupper(Repository::STATUS_OUTDATED) . '</span>';
                break;
            case Repository::STATUS_UPTODATE:
                $status = '<span class="label label-success">' . strtoupper(Repository::STATUS_UPTODATE) . '</span>';
                break;
            case Repository::STATUS_ERROR:
                $status = '<span class="label label-danger">' . strtoupper(Repository::STATUS_ERROR) . '</span>';
                break;
            case Repository::STATUS_CHECKING:
                $status = '<span class="label label-default">' . strtoupper(Repository::STATUS_CHECKING) . '</span>';
                break;
        }

        return $status;
    }
}
