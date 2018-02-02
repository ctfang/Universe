<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/22
 * Time: 10:21
 */

namespace Universe\Servers;

use Swoole\Http\Server;
use Universe\App;
use Universe\Swoole\Http\Request;
use Universe\Swoole\Http\Response;

class HttpServer
{
    private $server;

    public function __construct( Server $httpServer )
    {
        $this->server = $httpServer;
    }

    /**
     * 每个请求执行一次
     *
     * @param \Swoole\Http\Request $request
     * @param \Swoole\Http\Response $response
     * @author 明月有色 <2206582181@qq.com>
     */
    public function onRequest(\Swoole\Http\Request $request, \Swoole\Http\Response $response)
    {
        $request = new Request($request);
        $response = new Response($response);
        App::getDi()->get('dispatcher')->handle($request, $response);
    }

    /**
     * 服务器启动执行一次
     *
     * @param Server $server
     * @author 明月有色 <2206582181@qq.com>
     */
    public function onStart(Server $server)
    {

    }

    /**
     * 服务器关闭执行一次
     *
     * @param Server $server
     * @author 明月有色 <2206582181@qq.com>
     */
    public function onShutdown(Server $server)
    {
    }

    /**
     * 每个worker启动重启都会执行
     *
     * @param Server $server
     * @author 明月有色 <2206582181@qq.com>
     */
    public function onWorkerStart(Server $server)
    {
    }

    /**
     * 每个worker退出或重启都会执行
     *
     * @param Server $server
     * @param int $workerId
     * @author 明月有色 <2206582181@qq.com>
     */
    public function onWorkerStop(Server $server,int $workerId)
    {
    }

    /**
     * 浏览器链接
     *
     * @param Server $server
     * @param int $fd
     * @param int $reactorId
     * @author 明月有色 <2206582181@qq.com>
     */
    public function onConnect(Server $server,int $fd,int $reactorId)
    {

    }

    /**
     * 关闭浏览器执行一次
     *
     * @param Server $server
     * @param int $fd
     * @param int $reactorId
     * @author 明月有色 <2206582181@qq.com>
     */
    public function onClose(Server $server,int $fd,int $reactorId)
    {
    }
}