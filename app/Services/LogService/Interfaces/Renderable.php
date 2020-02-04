<?php


namespace App\Services\LogService\Interfaces;

/**
 * Interface Renderable
 * @package App\Services\LogService\Interfaces
 */
interface Renderable
{
    /**
     * Get the data.
     *
     * @return array
     */
    public function getData(): array;

    /**
     * Render contents of the data.
     *
     * @return mixed
     */
    public function render();
}
