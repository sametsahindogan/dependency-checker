<?php

namespace App\Services\LogService;

use App\Models\Log;

/**
 * Class RenderDatabase
 * @package App\Services\LogService
 */
class RenderDatabase extends LogDecorator
{

    /**
     * @return string|void
     */
    public function render()
    {
        Log::create($this->getData());
    }
}
