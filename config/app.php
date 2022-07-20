<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'app.name' => env('APP_NAME', 'Horizom'),


    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'app.env' => env('APP_ENVIRONMENT', 'production'),


    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'app.base_path' => env('APP_PATH', ''),

    'app.base_url' => env('APP_URL', 'http://localhost:8000'),

    'app.asset_url' => env('APP_ASSET_URL', null),


    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'app.timezone' => env('APP_TIMEZONE', 'UTC'),


    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'app.locale' => env('APP_LOCALE', 'en'),


    /*
    |--------------------------------------------------------------------------
    | System redirection Configuration
    |--------------------------------------------------------------------------
    |
    */

    'app.redirect.https' => env('APP_REDIRECT_HTTPS', true),

    'app.redirect.www' => env('APP_REDIRECT_WWW', true),


    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'app.display_errors' => env('APP_ERROR_HANDLER', true),

    'app.debug' => env('APP_DEBUG', false),


    /*
    |--------------------------------------------------------------------------
    | Others
    |--------------------------------------------------------------------------
    |
    */

    'app.robots' => env('APP_ROBOTS', false),


    /*
    |--------------------------------------------------------------------------
    | Storage Configuration
    |--------------------------------------------------------------------------
    |
    */

    'storage.filesystems' => [
        "local" => [
            'driver' => 'local',
            'root' => HORIZOM_ROOT . '/public/contents',
            'url' => url('contents'),
            'visibility' => 'public',
        ],
    ]
];
