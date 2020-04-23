<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Emails\Email;
use Illuminate\Http\Request;
use App\Jobs\CheckDependencyJob;
use App\Services\GitService\GitService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator;
use App\Models\Repositories\GitTypes;
use App\Services\GitService\Output\JsonOutput;
use App\Services\JsonResponseService\ResponseBuilderInterface;

/**
 * Class GitRepositoryController
 * @package App\Http\Controllers
 */
class GitRepositoryController extends Controller
{
    /** @var ResponseBuilderInterface $response */
    private $response;

    /** @var GitService $service */
    private $service;

    /**
     * GitRepositoryController constructor.
     * @param ResponseBuilderInterface $responseBuilder
     * @param GitService $service
     */
    public function __construct(ResponseBuilderInterface $responseBuilder, GitService $service)
    {
        $this->response = $responseBuilder;
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('repository.list');
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

        return $this->service->getAllRepositoriesWithGitProviders($sort, $sortType, $offset, $limit, new JsonOutput());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createPage()
    {
        return view('repository.add')->with(['emails' => Email::all(), 'gitTypes' => GitTypes::all()]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        /** @var Validator $validator */
        $validator = validator($request->all(), [
            'repo_url' => 'required|string',
            'emails' => 'nullable|array',
        ])->setAttributeNames([
            'repo_url' => 'Repo URL',
            'emails' => 'Email',
        ]);

        if ($validator->fails()) {
            return $this->getValidationErrorResponse($validator->errors());
        }

        try {

            $repository = $this->service->createRepository($request->get('type_id'), $request->get('repo_url'), $request->get('emails', []));

        } catch (Exception $e) {

            return response()->json($this->response
                ->result(false)
                ->message($e->getMessage())
                ->build()
            );
        }

        $this->dispatch(new CheckDependencyJob($repository->id));

        return response()->json($this->response
            ->message('The repository was successfully registered and queued for dependency control.')
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
