<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Services\EmailService\EmailService;
use Illuminate\Validation\Validator;
use App\Services\EmailService\Output\JsonOutput;
use App\Services\JsonResponseService\ResponseBuilderInterface;

/**
 * Class EmailController
 * @package App\Http\Controllers
 */
class EmailController extends Controller
{
    /** @var EmailService $service */
    private $service;

    /** @var ResponseBuilderInterface $response */
    private $response;

    /**
     * EmailController constructor.
     * @param ResponseBuilderInterface $response
     * @param EmailService $service
     */
    public function __construct(ResponseBuilderInterface $response, EmailService $service)
    {
        $this->service = $service;
        $this->response = $response;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('email.list');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function get(Request $request)
    {
        $sort = $request->get('sort', 'id');
        $sortType = $request->get('order', 'desc');
        $offset = (int)$request->get('offset', 0);
        $limit = (int)$request->get('limit', 10);

        return $this->service->getAllEmails($sort, $sortType, $offset, $limit, new JsonOutput());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function createPage()
    {
        return view('email.add');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        /** @var Validator $validator */
        $validator = validator($request->all(), [
            'title' => 'required|email',
        ])->setAttributeNames([
            'title' => 'E-Mail Address',
        ]);

        if ($validator->fails())
            return $this->getValidationErrorResponse($validator->errors());

        $this->service->create($request->get('title'));

        return response()->json($this->response->message("Successfully added.")->build());
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function updatePage($id)
    {
        return view('email.edit')->with(['email' => $this->service->getById($id)]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        /** @var Validator $validator */
        $validator = validator($request->all(), [
            'title' => 'required|email',
        ])->setAttributeNames([
            'title' => 'E-Mail Address',
        ]);

        if ($validator->fails())
            return $this->getValidationErrorResponse($validator->errors());

        try {

            $this->service->updateById($request->get('id'), $request->get('title'));

        } catch (Exception $e) {
            return response()->json($this->response
                ->result(false)
                ->message($e->getMessage())
                ->build()
            );
        }

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
        return view('email.remove')->with(['email' => $this->service->getById($id)]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        try {

            $this->service->deleteById($request->get('id'));

        } catch (Exception $e) {
            return response()->json($this->response
                ->result(false)
                ->message($e->getMessage())
                ->build()
            );
        }

        return response()->json($this->response
            ->message("Record deleted.")
            ->build()
        );
    }

    protected function getValidationErrorResponse(MessageBag $errors)
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


}
