<?php

require __DIR__ . '/../bootstrap/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';

$di = $app::getDi();


$request  = new \Universe\Swoole\Http\Request();
$response = new \Universe\Swoole\Http\Response();

try{
    $di->get('dispatcher')->handle($request, $response);
}catch (\Exception $exception){
    // 命令行打印错误
    $response->end(dd($exception));
}
