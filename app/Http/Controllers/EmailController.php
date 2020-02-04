<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Interfaces\EmailController\RenderJson;
use App\Http\Controllers\Interfaces\EmailController\RenderView;
use App\Models\Email;
use App\Services\JsonResponseService\ResponseBuilderInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\View\View;

/**
 * Class EmailController
 * @package App\Http\Controllers
 */
class EmailController extends BaseCrudController implements RenderView, RenderJson
{
    /**
     * EmailController constructor.
     * @param ResponseBuilderInterface $responseBuilder
     * @param Email $model
     */
    public function __construct(ResponseBuilderInterface $responseBuilder, Email $model)
    {
        $this->response = $responseBuilder;
        $this->model = $model;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('email.list');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        $sort = $request->get('sort', 'id');
        $sortType = $request->get('order', 'desc');
        $offset = (int)$request->get('offset', 0);
        $limit = (int)$request->get('limit', 10);

        /** @var Builder $queryBuilder */
        $queryBuilder = new $this->model();

        $total = $queryBuilder->count();

        $datas = $queryBuilder->orderBy($sort, $sortType)
            ->offset($offset)
            ->limit($limit)
            ->get();

        $rows = [];
        foreach ($datas as $key => $data) {
            $rows[] = [
                "id" => $data->id,
                "order" => $offset + $key + 1,
                "title" => $data->title,
                "created_at" => $data->created_at->isoFormat('dddd, DD MMMM Y HH:mm'),
                "options" => '<div class="tabledit-toolbar btn-toolbar d-block">
                                <div class="btn-group btn-group-sm">
                                    <a href="' . route('emails.updatePage', ['id' => $data->id]) . '" data-toggle="modal" data-target="#modalsm" class="tabledit-edit-button btn btn-sm btn-warning"><span class="glyphicon glyphicon-pencil"></span></a>
                                    <a href="' . route('emails.deletePage', ['id' => $data->id]) . '" data-toggle="modal" data-target="#modalsm" class="tabledit-delete-button btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                                </div>
                              </div>'
            ];
        }

        $output = [
            "total" => $total,
            "rows" => $rows
        ];

        return response()->json($output);
    }

    /**
     * @return View
     */
    public function createPage(): View
    {
        return view('email.add');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        /** @var Validator $validator */
        $validator = validator($request->all(), [
            'title' => 'required|email',
        ])->setAttributeNames([
            'title' => 'E-Mail Address',
        ]);

        if ($validator->fails())
            return $this->getErrorResponse($validator->errors());

        $this->model::create([
            'title' => $request->get('title')
        ]);

        return response()->json($this->response
            ->message("Successfully added.")
            ->build()
        );
    }

    /**
     * @param $id
     * @return View
     * @throws \Exception
     */
    public function updatePage($id): View
    {
        return view('email.edit')->with(['email' => $this->getRecordById($id)]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        /** @var Validator $validator */
        $validator = validator($request->all(), [
            'title' => 'required|email',
        ])->setAttributeNames([
            'title' => 'E-Mail Address',
        ]);

        if ($validator->fails())
            return $this->getErrorResponse($validator->errors());

        try
        {
            /** @var Email $email */
            $email = $this->getRecordById($request->get('id'));
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json($this->response
                ->result(false)
                ->message($e->getMessage())
                ->build()
            );
        }

        $email->update(['title' => $request->get('title')]);

        return response()->json($this->response
            ->message("Successfully updated.")
            ->build()
        );
    }

    /**
     * @param $id
     * @return View
     */
    public function deletePage($id): View
    {
        return view('email.remove')->with(['email' => $this->getRecordById($id)]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        try
        {
            /** @var Email $record */
            $email = $this->getRecordById($request->get('id'));
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json($this->response
                ->result(false)
                ->message($e->getMessage())
                ->build()
            );
        }

        $email->delete();

        return response()->json($this->response
            ->message("Record deleted.")
            ->build()
        );
    }

}
