<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'github' => [
        'api_url' => env('GITHUB_API_URL', 'https://api.github.com')
    ],

    'bitbucket' => [
        'api_url' => env('BITBUCKET_API_URL', 'https://api.bitbucket.org')
    ],

    'npm' => [
        'api_url' => env('NPM_API_URL', 'https://registry.npmjs.org')
    ],

    'packagist' => [
        'api_url' => env('PACKAGIST_API_URL', 'https://packagist.org/packages')
    ],

    'script_cache' => env('SCRIPT_CACHE_VERSION', '0.001')

];
