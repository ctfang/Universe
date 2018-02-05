<?php
$app = new \Universe\App(dirname(__DIR__));

error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * 注册全局服务
 * 原则上是，注册阶段不要有业务
 */
$app->initializeServices([
    \Universe\Providers\ConfigServerProvider::class,
    \Universe\Providers\LoggerServiceProvider::class,
    \Universe\Providers\HttpServiceProvider::class,
    \Universe\Providers\ExceptionServerProvider::class,
    \Universe\Providers\DispatcherServiceProvider::class,
    \Universe\Providers\OutputServerProvider::class,
    \Universe\Providers\DatabaseServerProvider::class,
]);

return $app;