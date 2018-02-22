<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/22
 * Time: 9:46
 */

namespace Universe\Providers;


use App\Events\HttpEvent;
use Swoole\Http\Server;
use Universe\App;

class HttpServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'server';

    protected $onList = [
        'onRequest'=>'Request',
        'onStart'=>'Start',
        'onShutdown'=>'Shutdown',
        'onWorkerStart'=>'WorkerStart',
        'onWorkerStop'=>'WorkerStop',
        'onConnect'=>'Connect',
        'onClose'=>'Close',
        'onTask'=>'Task',
        'onFinish'=>'Finish',
    ];

    public function register()
    {
        $this->di->set($this->serviceName,function (){
            $serverConfig = App::getShared('config')->get('server');
            $httpServer = new Server($serverConfig['http']['host'],$serverConfig['http']['port']);
            $httpServer->set($serverConfig['http']['set']);
            $http = new HttpEvent();
            foreach ($this->onList as $function=>$event){
                $httpServer->on($event,[$http,$function]);
            }
            return $httpServer;
        });
    }
}