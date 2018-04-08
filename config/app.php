<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/18
 * Time: 20:27
 */

use Universe\Support\Swoole;
use App\Http\Controllers\WebSocketTestController;

return [
    // 项目名称
    'name' => env('APP_NAME', 'universe'),
    // 环境名称
    'env' => env('APP_ENV', 'production'),
    // 调试模式
    'debug' => env('APP_DEBUG', false),
    // 根目录
    'base_path'=>dirname(__DIR__),
    // 日记等级
    'log_level' => env('APP_LOG_LEVEL', 'debug'),
    // 历史log存储日期
    'log_max_files' => 30,
    // 服务
    'server'=>[
        // 服务协议
        'http'=>[
            // 可访问域名
            'host'=>env('SERVER_HOST','*.*.*.*'),
            // 监听端口
            'port'=>env('SERVER_PORT','8080'),
            // swoole server 配置
            'set'=>[
                'log_file' => dirname(__DIR__) . "/storage/http/swoole.log",
                'pid_file' => dirname(__DIR__) . '/bootstrap/cache/http/server.pid',
                'log_level' => 5,
                'worker_num' => env('SERVER_WORKER_NUM', 4),
                'task_worker_num'=>0,
            ],
            'work_mode' => env('WORK_MODE', 3),
            'server_type' => Swoole::TYPE_HTTP
        ],
        // 服务协议
        'websocket'=>[
            // 可访问域名
            'host'=>env('WEBSOCKET_SERVER_HOST','0.0.0.0'),
            // 监听端口
            'port'=>env('WEBSOCKET_SERVER_PORT','9501'),
            // swoole server 配置
            'set'=>[
                'log_file' => dirname(__DIR__) . "/storage/websocket/swoole.log",
                'pid_file' => dirname(__DIR__) . '/bootstrap/cache/websocket/server.pid',
                'log_level' => 5,
                'worker_num' => env('WEBSOCKET_SERVER_WORKER_NUM', 4),
            ],
            'work_mode' => env('WORK_MODE', 3),
            'server_type' => Swoole::TYPE_WEBSOCKET,
            'callback' => new WebSocketTestController
        ],
    ],
];