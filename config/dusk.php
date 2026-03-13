<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel Dusk
    |--------------------------------------------------------------------------
    |
    | The application name.
    |
    */

    'app_name' => env('DUSK_APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Dusk Server
    |--------------------------------------------------------------------------
    |
    | This setting determines the URL that Dusk will use when calling your
    | application. You should update this if you are using a custom domain.
    |
    */

    'app_url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Dusk ChromeDriver
    |--------------------------------------------------------------------------
    |
    | This setting determines which ChromeDriver version will be used when
    | running Dusk tests. You may specify 'latest' to use the latest
    | version or a specific version number.
    |
    */

    'chrome_driver' => env('DUSK_CHROME_DRIVER', '122'),

    /*
    |--------------------------------------------------------------------------
    | Dusk Paths
    |--------------------------------------------------------------------------
    |
    | Here you may configure the paths that Dusk will use to look for tests
    | and other relevant files. Generally, you should not need to modify
    | these paths.
    |
    */

    'paths' => [

        'tests' => base_path('tests/Browser'),

        'screenshots' => base_path('tests/Browser/screenshots'),

        'console' => base_path('tests/Browser/console'),

        'source' => base_path('tests/Browser/source'),

    ],

];