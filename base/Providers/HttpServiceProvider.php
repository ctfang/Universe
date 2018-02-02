<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/22
 * Time: 9:46
 */

namespace Universe\Providers;


use Swoole\Http\Server;
use Universe\App;
use Universe\Servers\HttpServer;

class HttpServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'http';

    protected $onList = [
        'onRequest'=>'Request',
        'onStart'=>'Start',
        'onShutdown'=>'Shutdown',
        'onWorkerStart'=>'WorkerStart',
        'onWorkerStop'=>'WorkerStop',
        'onConnect'=>'Connect',
        'onClose'=>'Close',
    ];

    public function register()
    {
        $this->di->set($this->serviceName,function (){
            $serverConfig = App::getDi()->getShared('config')->get('server');
            $httpServer = new Server($serverConfig['http']['host'],$serverConfig['http']['port']);
            $httpServer->set($serverConfig['set']);
            $http = new HttpServer($httpServer);
            foreach ($this->onList as $function=>$event){
                $httpServer->on($event,[$http,$function]);
            }
            return $httpServer;
        });
    }
}