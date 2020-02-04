<?php

namespace App\Http\Controllers\Interfaces\DependencyController;

use Illuminate\View\View;

/**
 * Interface RenderView
 * @package App\Http\Controllers\Interfaces\DependencyController
 */
interface RenderView
{
    /**
     * @param $repo_slug
     * @param $project_slug
     * @return mixed
     */
    public function index($repo_slug, $project_slug);
}
