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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
     'google' => [
        'client_id' => '22216784316-4otdclm580jfkajn2f67g2vs4hiht380.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => '/callback/google',
    ],

    'linkedin' => [
        'client_id' => '77fmedn0mszmhz',
        'client_secret' => '0VZk5u9cVT2ljFN6',
        'redirect' => '/callback/linkedin',
    ],
     // Configure Google ReCAPTCHA v3 key+secret

    'recaptcha' => [
        'key' => env('RECAPTCHA_SITE_KEY'),
        'secret' => env('RECAPTCHA_SECRET_KEY'),
    ]

];
