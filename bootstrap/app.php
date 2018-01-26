<?php
$app = new \Universe\App(dirname(__DIR__));

$app->initializeServices([
    \Universe\Providers\HttpServiceProvider::class,
    \Universe\Providers\DispatcherServiceProvider::class,
]);

return $app;