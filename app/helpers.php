<?php

if (!function_exists('authed')) {
    /**
     * @return mixed
     */
    function authed()
    {
        return request()->authed_user;
    }
}
