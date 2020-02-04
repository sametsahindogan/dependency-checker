<?php

namespace App\Http\Controllers\Interfaces\GithubRepositoryController;

use Illuminate\View\View;

/**
 * Interface RenderView
 * @package App\Http\Controllers\Interfaces\GithubRepositoryController
 */
interface RenderView
{
    /**
     * @return View
     */
    public function index();

    /**
     * @return View
     */
    public function createPage();
}
