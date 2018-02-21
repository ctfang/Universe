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
    \Universe\Providers\RequestServerProvider::class,
    \Universe\Providers\ResponseServerProvider::class,
    \Universe\Providers\ExceptionServerProvider::class,
    \Universe\Providers\DispatcherServiceProvider::class,
    \Universe\Providers\DatabaseServerProvider::class,
    \Universe\Providers\CacheServerProvider::class,
    \Universe\Providers\ViewServerProvider::class,
    \Universe\Providers\SessionServerProvider::class,

    \App\Providers\FacadeServiceProvider::class,
    \App\Providers\EventServiceProvider::class,
]);

$app::getShared('facade')->register();

return $app;