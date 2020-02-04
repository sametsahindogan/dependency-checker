<?php

namespace App\Http\Controllers\Interfaces\EmailController;

use Illuminate\View\View;

/**
 * Interface RenderView
 * @package App\Http\Controllers\Interfaces\EmailController
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

    /**
     * @param $id
     * @return View
     */
    public function updatePage($id);

    /**
     * @param $id
     * @return View
     */
    public function deletePage($id);
}
