<?php

namespace App\Http\Controllers\Interfaces\DependencyController;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Interface RenderJson
 * @package App\Http\Controllers\Interfaces\DependencyController
 */
interface RenderJson
{
    /**
     * @param Request $request
     * @param $repo_slug
     * @param $project_slug
     * @return mixed
     */
    public function get(Request $request, $repo_slug, $project_slug);
}
