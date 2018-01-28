<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/18
 * Time: 20:27
 */
return [

    'name' => env('APP_NAME', 'universe'),

    'env' => env('APP_ENV', 'production'),

    'debug' => env('APP_DEBUG', false),


    'server'=>[
        'http'=>[
            'host'=>env('SERVER_HOST','*.*.*.*'),
            'port'=>env('SERVER_PORT','8080'),
        ],
    ],
];