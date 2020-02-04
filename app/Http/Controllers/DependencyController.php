<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Interfaces\DependencyController\RenderJson;
use App\Http\Controllers\Interfaces\DependencyController\RenderView;
use App\Models\Dependency;
use App\Models\Repository;
use App\Services\JsonResponseService\ResponseBuilderInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class DependencyController
 * @package App\Http\Controllers
 */
class DependencyController extends BaseCrudController implements RenderView, RenderJson
{
    /**
     * GithubRepositoryController constructor.
     * @param ResponseBuilderInterface $responseBuilder
     * @param Repository $model
     */
    public function __construct(ResponseBuilderInterface $responseBuilder, Repository $model)
    {
        $this->response = $responseBuilder;
        $this->model = $model;
    }

    /**
     * @param $repo_slug
     * @param $project_slug
     * @return View
     */
    public function index($repo_slug, $project_slug): View
    {
        return view('dependency.list', ['repo' => $repo_slug, 'project' => $project_slug]);
    }

    /**
     * @param Request $request
     * @param $repo_slug
     * @param $project_slug
     * @return JsonResponse
     */
    public function get(Request $request, $repo_slug, $project_slug): JsonResponse
    {
        /** @var Model $queryBuilder */
        $data = (new $this->model())->with([
            'dependencies' => function ($query) {
                $query->with('type');
            }
        ])->where(['repo_slug' => $repo_slug, 'project_slug' => $project_slug])->first();

        $rows = [];
        foreach ($data->dependencies as $key => $data) {

            $rows[] = [
                "id" => $data->id,
                "type" => '<img src="' . asset('start-ui/img/' . $data->type->title . '.png') . '">',
                "title" => '<b>' . $data->title . '</b>',
                "current_version" => $data->current_version,
                "latest_version" => $data->latest_version,
                "status" => $this->getStatus($data->status)
            ];
        }

        $output = [
            "rows" => $rows
        ];

        return response()->json($output);
    }

}
