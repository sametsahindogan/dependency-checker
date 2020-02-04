<?php

namespace App\Http\Controllers\Interfaces\GithubRepositoryController;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Interface RenderJson
 * @package App\Http\Controllers\Interfaces\GithubRepositoryController
 */
interface RenderJson
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function get(Request $request);

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request);
}
