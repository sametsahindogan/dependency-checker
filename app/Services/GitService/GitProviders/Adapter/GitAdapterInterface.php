<?php


namespace App\Services\GitService\Adapter;


interface GitAdapterInterface
{
    public function setRepo(string $data);

    public function call();
}
