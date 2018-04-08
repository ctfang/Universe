<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/22
 * Time: 9:46
 */

namespace Universe\Providers;


use App\Events\WebSocketEvent;
use Swoole\WebSocket\Server;
use Universe\App;
use Universe\Support\Swoole;

class WebSocketServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'webSocketServer';

    /**
     * WebSocketServer 事件，【函数名】=》【对应事件】
     *
     * 'onStart'=>'Start',
     * 'onManagerStart'=>'ManagerStart',
     * 'onWorkerStart'=>'WorkerStart',
     * 'onOpen'=>'Open',
     * 'onMessage'=>'Message',
     * 'onClose'=>'Close',
     */
    protected $onList = [
        'onRequest'=>'Request',
        'onStart'=>'Start',
        'onManagerStart'=>'ManagerStart',
        'onWorkerStart'=>'WorkerStart',
        'onOpen'=>'Open',
        'onRequest'=>'Request',
        'onMessage'=>'Message',
        'onClose'=>'Close',
    ];

    public function register()
    {
        $this->di->set($this->serviceName,function (){
            $serverConfig = App::getShared('config')->get('server');
            $socketType = empty($serverConfig['websocket']['server_type']) ? Swoole::TYPE_WEBSOCKET : strtolower($serverConfig['websocket']['server_type']);
            $ssl = 0;
            if (!empty($serverConfig['websocket']['ssl_cert_file']) && !empty($serverConfig['websocket']['ssl_key_file'])) {
                $ssl = \SWOOLE_SSL;
            }
            $workMode = empty($serverConfig['websocket']['work_mode']) ? SWOOLE_PROCESS : $serverConfig['websocket']['work_mode'];

            switch ($socketType) {
                case Swoole::TYPE_WEBSOCKET:
                    $webSocketServer = new Server($serverConfig['websocket']['host'], $serverConfig['websocket']['port'], $workMode);
                    break;
                case Swoole::TYPE_WEBSOCKETS:
                    if (!$ssl) {
                        throw new \Exception("websockets must set ssl_cert_file && ssl_key_file");
                    }
                    $webSocketServer = new Server($serverConfig['websocket']['host'], $serverConfig['websocket']['port'], $workMode, \SWOOLE_SOCK_TCP | \SWOOLE_SSL);
                    break;
            }
            $webSocketServer->set($serverConfig['websocket']['set']);
            $webSocket = new WebSocketEvent();
            foreach ($this->onList as $function=>$event) {
                $webSocketServer->on($event,[$webSocket, $function]);
            }

            if (isset($serverConfig['websocket']['callback'])) {
                $webSocket->setCallback($serverConfig['websocket']['callback']);
            }
            return $webSocketServer;
        });
    }
}