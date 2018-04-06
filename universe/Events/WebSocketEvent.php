<?php
namespace Universe\Events;

use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\WebSocket\Server;
use Swoole\WebSocket\Frame;
use Universe\Swoole\Process;
use Universe\App;

class WebSocketEvent
{
    private $callback;

    // onStart 主进程启动事件
    public function onStart(Server $server)
    {
        // 检查目录、注册集群等
    }

    // onRequest
    public function onRequest(Request $sRequest, Response $sResponse)
    {
        ob_start();

        $request     = App::get('request');
        $response    = App::get('response');

        $request->set($sRequest,$sResponse);
        $response->set($request);

        $disResponse = App::getShared('dispatcher')->handle($request, $response);

        if( ob_get_level() > 0 && $contents = ob_get_clean() ){
            while (ob_get_level() > 0) {
                $contents .= ob_get_clean();
            }
            $response->end($contents.$disResponse??'');
        }elseif($disResponse!==null){
            $response->end($disResponse);
        }
        $this->endRequest();
    }

    // onManagerStart 管理进程启动事件
    public function onManagerStart(Server $server)
    {
        // 进程命名
        Process::setName("universe-websocketd: manager");
    }


    // onWorkerStart 管理进程启动事件
    public function onWorkerStart(Server $server, int $workerId)
    {
        // 进程命名
        if ($workerId < $server->setting['worker_num']) {
            Process::setName("universe-websocketd: worker #{$workerId}");
        } else {
            Process::setName("universe-websocketd: task #{$workerId}");
        }
    }


    // onOpen 客户端与服务器建立连接并完成握手后会回调此函数
    public function onOpen(Server $server, Request $sRequest)
    {
//        echo "server: handshake success with fd{$sRequest->fd}\n";



    }

    // onMessage 当服务器收到来自客户端的数据帧时会回调此函数
    public function onMessage(Server $server, Frame $frame)
    {
        try {
            $method = 'onMessage';
            if (method_exists($this->callback, $method)) {
                list($object, $method) = [$this->callback, $method];
                $object->$method($server, $frame);
            }
        } catch (\Exception $e) {
            \Log::error(__METHOD__, $e->getTrace());
        }

    }

    // onClose 链接关闭
    public function onClose(Server $server, int $fd)
    {
        try {
            $method = 'onClose';
            if (method_exists($this->callback, $method)) {
                list($object, $method) = [$this->callback, $method];
                $object->$method($server, $fd);
            }
        } catch (\Exception $e) {
            \Log::error(__METHOD__, $e->getTrace());
        }
    }

    public function endRequest()
    {

    }

    public function setCallback($callback)
    {
        $this->callback = $callback;
    }
}