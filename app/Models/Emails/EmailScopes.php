<?php


namespace App\Models\Emails;

/**
 * Trait EmailScopes
 * @package App\Models\Emails
 */
trait EmailScopes
{
    /***
     * @param string $title
     * @return mixed
     */
    public function updateTitle(string $title)
    {
        return $this->update(['title' => $title]);
    }
}
