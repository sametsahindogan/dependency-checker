<?php

namespace App\Http\Controllers\Interfaces\EmailController;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Interface RenderJson
 * @package App\Http\Controllers\Interfaces\EmailController
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request);

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request);
}
