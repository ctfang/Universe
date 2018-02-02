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


    /**
     * 根目录
     */
    'base_path'=>dirname(__DIR__),

    /**
     * 日记配置
     * 记录最小log级别
     */
    'log_level' => env('APP_LOG_LEVEL', 'debug'),
    /**
     * 历史log存储日期
     */
    'log_max_files' => 30,

    'server'=>[
        'http'=>[
            'host'=>env('SERVER_HOST','*.*.*.*'),
            'port'=>env('SERVER_PORT','8080'),
        ],
        'set'=>[
            'deamonize'=>false,
            'log_file' => dirname(__DIR__)."/storage/swoole.log",
            'pid_file' => dirname(__DIR__) . '/storage/server.pid',
            'log_level' => 5,
            'worker_num' => 4,    //worker process num
        ],
    ],
];