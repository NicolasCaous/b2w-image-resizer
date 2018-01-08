<?php

    return [
        'default' => 'mongodb',
        'connections' => [
             'mongodb' => [
                'driver'   => 'mongodb',
                'dsn' => 'mongodb://admin:admin@ds245347.mlab.com:45347/b2w-image-resizer',
                'database' => 'b2w-image-resizer',
            //    'driver' => 'mongodb',
            //    'host' => rawurlencode(env('DB_HOST', 'ds245347.mlab.com')),
            //    'port' => env('DB_PORT', 45347),
            //    'database' => rawurlencode(env('DB_DATABASE', 'b2w-image-resizer')),
            //    'username' => env('DB_USERNAME', 'admin'),
            //    'password' => env('DB_PASSWORD', 'admin'),
            //    'options' => [
            //        'database' => 'admin' // sets the authentication database required by mongo 3
            //    ]
            ],
        ],
        'migrations' => 'migrations',
    ];
