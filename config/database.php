<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Database Migrations table Name
    |--------------------------------------------------------------------------
    |
    */

    'database.migrations_table' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'database.default' => 'development',

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'database.connections' => [

        'development' => [
            'driver' => env('DB_DRIVER', 'mysql'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_POST', '3306'),
            'database' => env('DB_DATABASE', 'database'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_PREFIX', ''),
        ],

        'production' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'port' => '3306',
            'database' => 'database',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => ''
        ]

    ]

];
