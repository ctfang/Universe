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
use Universe\Support\Swoole;


class HttpServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'httpServer';

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
            $socketType = empty($serverConfig['http']['server_type']) ? Swoole::TYPE_HTTP : strtolower($serverConfig['http']['server_type']);
            $ssl = 0;

            if (!empty($serverConfig['http']['ssl_cert_file']) && !empty($serverConfig['http']['ssl_key_file'])) {
                $ssl = \SWOOLE_SSL;
            }
            $workMode = empty($serverConfig['http']['work_mode']) ? SWOOLE_PROCESS : $serverConfig['http']['work_mode'];

            switch ($socketType) {
                case Swoole::TYPE_HTTP:
                    $httpServer = new Server($serverConfig['http']['host'], $serverConfig['http']['port'], $workMode);
                    break;
                case Swoole::TYPE_HTTPS:
                    if (!$ssl) {
                        throw new \Exception("https must set ssl_cert_file && ssl_key_file");
                    }
                    $httpServer = new Server($serverConfig['http']['host'], $serverConfig['http']['port'], $workMode, \SWOOLE_SOCK_TCP | \SWOOLE_SSL);
                    break;
            }

            $httpServer->set($serverConfig['http']['set']);
            $http = new HttpEvent();
            foreach ($this->onList as $function => $event) {
                $httpServer->on($event, [$http, $function]);
            }
            return $httpServer;
        });
    }
}