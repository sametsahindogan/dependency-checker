<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Interfaces\GithubRepositoryController\RenderJson;
use App\Http\Controllers\Interfaces\GithubRepositoryController\RenderView;
use App\Jobs\CheckDependencyJob;
use App\Models\Email;
use App\Models\GitTypes;
use App\Models\Repository;
use App\Services\GitService\GitFactory;
use App\Services\GitService\GitRequest;
use App\Services\GitService\GitResponse;
use App\Services\JsonResponseService\ResponseBuilderInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\View\View;

/**
 * Class GitRepositoryController
 * @package App\Http\Controllers
 */
class GitRepositoryController extends BaseCrudController implements RenderView, RenderJson
{
    /** @var string $repo */
    protected $repo;

    /** @var GitRequest $gitFactory */
    protected $gitFactory;

    /**
     * GithubRepositoryController constructor.
     * @param ResponseBuilderInterface $responseBuilder
     * @param Repository $model
     */
    public function __construct(ResponseBuilderInterface $responseBuilder, GitFactory $gitFactory, Repository $model)
    {
        $this->response = $responseBuilder;
        $this->gitFactory = $gitFactory;
        $this->model = $model;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('repository.list');
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
        $queryBuilder = (new $this->model())->with('gitProvider');

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
                "provider" =>'<img src="' . asset('start-ui/img/' . $data->gitProvider->title . '.png') . '" width="75">',
                "status" => $this->getStatus($data->status),
                "slug" => '<a href="' . route('dependencies', ['repo_slug' => $data->repo_slug, 'project_slug' => $data->project_slug]) . '"><b>' . $data->repo_slug . '/' . $data->project_slug . '</b></a>',
                "checked_at" => $data->checked_at ? $data->checked_at->isoFormat('DD MMMM Y HH:mm') : '-',
                "created_at" => $data->created_at->isoFormat('DD MMMM Y HH:mm'),
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
        return view('repository.add')->with(['emails' => Email::all(), 'gitTypes' => GitTypes::all()]);
    }

    /**
     * @param Request $request
     * @return JsonResponse|string
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

        if ($validator->fails())
            return $this->getErrorResponse($validator->errors());

        /** @var GitTypes $gitProvider */
        $gitProvider = GitTypes::find($request->get('type_id'));

        /** @var array $formatedUrl */
        $formatedUrl = $this->formatUrl($gitProvider->title, $request->get('repo_url'));

        if (!$formatedUrl) {
            return response()->json($this->response
                ->result(false)
                ->message('Please enter valid Git Repository address')
                ->build()
            );
        }

        if ($this->getRecordBySlug([
            'repo_slug' => $formatedUrl[0],
            'project_slug' => $formatedUrl[1]
        ])) {
            return response()->json($this->response
                ->result(false)
                ->message('This repository is already saved.')
                ->build()
            );
        }

        /** @var GitResponse|array $repo */
        $repo = $this->gitFactory->make($gitProvider->title)->getRepoWithDependencies($this->repo);

        if ($repo instanceof GitResponse) {
            return response()->json($this->response
                ->result(false)
                ->message('Repository not found.')
                ->build()
            );
        }

        /** @var array $repo */
        if (empty($repo['dependencies'])) {
            return response()->json($this->response
                ->result(false)
                ->message('No dependency found in this repository.')
                ->build()
            );
        }

        $this->model->type_id = $request->get('type_id');
        $this->model->status = 'checking';
        $this->model->repo_slug = $formatedUrl[0];
        $this->model->project_slug = $formatedUrl[1];
        $this->model->repo_url = $request->get('repo_url');
        $this->model->repo_id = $repo['repo_id'];
        $this->model->save();

        foreach ($repo['dependencies'] as $dependency) {
            $this->model->dependencies()->create($dependency);
        }

        if ($request->has('emails')) $this->attachEmail($request->get('emails'));

        dispatch((new CheckDependencyJob($this->model->id)));

        return response()->json($this->response
            ->message('The repository was successfully registered and queued for dependency control.')
            ->build()
        );

    }

    /**
     * @param $url
     * @return string
     */
    protected function formatUrl(string $provider, string $url)
    {
        $url = str_replace('/src/master/','',$url);

        $this->repo = str_replace('https://' . $provider . '.'.$this->providerExtension($provider).'/', '', $url);

        $formatedUrl = explode('/', $this->repo);

        if (count($formatedUrl) !== 2) return false;

        return $formatedUrl;
    }

    /**
     * @param $provider
     * @return string
     */
    protected function providerExtension($provider)
    {
        switch ($provider){
            case 'github':
                return 'com';
                break;
            case 'bitbucket':
                return 'org';
                break;
        }
    }

    /**
     * @param array $emails
     */
    protected function attachEmail(array $emails)
    {
        $this->model->emails()->attach($emails);
    }
}
