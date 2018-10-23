<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '366332283866407',
        'client_secret' => 'd72a14ab32f1edb6fa90b6140e7d5702',
        'redirect' => 'http://maverickpreviews.com/programming/zuslo/public/facebook/callback',
    ],

    'google' => [
        'client_id'     => '1065926023028-ugdch2c9vt4mh38570ro791k7s5lfe21.apps.googleusercontent.com',
        'client_secret' => 'zNtfpeStYAxEVzKLne4fBVHD',
        'redirect'      => 'http://localhost/zuslo/public/google/callback',
    ],

];
