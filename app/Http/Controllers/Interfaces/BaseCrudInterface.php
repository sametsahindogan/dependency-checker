<?php

namespace App\Http\Controllers\Interfaces;

use Illuminate\Support\MessageBag;

/**
 * Interface BaseCrudInterface
 * @package App\Http\Controllers\Interfaces
 */
interface BaseCrudInterface
{
    /**
     * @param string $id
     * @return mixed
     */
    public function getRecordById(string $id);

    /**
     * @param array $slug
     * @return mixed
     */
    public function getRecordBySlug(array $slug);

    /**
     * @param MessageBag $errors
     * @return mixed
     */
    public function getErrorResponse(MessageBag $errors);

}
