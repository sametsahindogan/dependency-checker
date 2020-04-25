<?php

use App\Models\Repositories\Repository;

if (!function_exists('authed')) {
    /**
     * @return mixed
     */
    function authed()
    {
        return request()->authed_user;
    }
}

if (!function_exists('getStatus')) {
    /**
     * @return mixed
     */
    function getStatus(string $status)
    {
        switch ($status) {
            case Repository::STATUS_OUTDATED:
                $status = '<span class="label label-warning">' . strtoupper(Repository::STATUS_OUTDATED) . '</span>';

                break;
            case Repository::STATUS_UPTODATE:
                $status = '<span class="label label-success">' . strtoupper(Repository::STATUS_UPTODATE) . '</span>';

                break;
            case Repository::STATUS_ERROR:
                $status = '<span class="label label-danger">' . strtoupper(Repository::STATUS_ERROR) . '</span>';

                break;
            case Repository::STATUS_CHECKING:
                $status = '<span class="label label-default">' . strtoupper(Repository::STATUS_CHECKING) . '</span>';

                break;
        }

        return $status;
    }
}
