<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Services\EmailService\EmailService;
use Illuminate\Validation\Validator;
use App\Services\EmailService\Output\JsonOutput;
use App\Services\JsonResponseService\ResponseBuilderInterface;
use Illuminate\View\View;

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
     * @return View
     */
    public function index(): View
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
            return $this->getValidationErrorResponse($validator->errors());

        $this->service->create($request->get('title'));

        return response()->json($this->response->message("Successfully added.")->build());
    }


    public function updatePage($id)
    {
        return view('email.edit')->with(['email' => $this->service->getById($id)]);
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
     * @throws Exception
     */
    public function deletePage($id): View
    {
        return view('email.remove')->with(['email' => $this->service->getById($id)]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
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

    /**
     * @param MessageBag $errors
     * @return JsonResponse
     */
    protected function getValidationErrorResponse(MessageBag $errors): JsonResponse
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
