<?php
$app = new \Universe\App(dirname(__DIR__));

$app->initializeServices([
    \Universe\Providers\ConfigServerProvider::class,
    \Universe\Providers\HttpServiceProvider::class,
    \Universe\Providers\ExceptionServerProvider::class,
    \Universe\Providers\DispatcherServiceProvider::class,

    \Universe\Providers\ExportServerProvider::class,
]);

return $app;