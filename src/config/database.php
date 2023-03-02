<?php

return [
    'default'   => [
        'driver'    => env('DB_DRIVER', 'mysql'),
        'host'      => env('DB_HOST', '127.0.0.1'),
        'database'  => env('DB_NAME', ''),
        'username'  => env('DB_USER', ''),
        'password'  => env('DB_PASSWORD', ''),
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => env('DB_PREFIX', ''),
        'port'      => env('DB_PORT', '3306'),
    ]

];