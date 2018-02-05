<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/22
 * Time: 10:21
 */

namespace Universe\Events;

use Swoole\Http\Server;
use Universe\App;
use Universe\Swoole\Http\Request;
use Universe\Swoole\Http\Response;

class HttpEvent
{
    /**
     * 每个请求执行一次
     *
     * @param \Swoole\Http\Request $request
     * @param \Swoole\Http\Response $response
     * @return \Swoole\Http\Response|Response
     * @author 明月有色 <2206582181@qq.com>
     */
    public function onRequest(\Swoole\Http\Request $request, \Swoole\Http\Response $response)
    {
        ob_start();

        $request = new Request($request);
        $response = new Response($response);
        $disResponse = App::get('dispatcher')->handle($request, $response);

        if( ob_get_status() && $contents = ob_get_clean() ){
            // 如果缓冲区还在开始，并且有内容输出
            $response->end($contents);
        }
        if( $disResponse instanceof Response){
            return $disResponse;
        }
    }

    /**
     * 服务器启动执行一次
     *
     * @param Server $server
     * @author 明月有色 <2206582181@qq.com>
     */
    public function onStart(Server $server)
    {
        // 检查目录、注册集群等
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
        /**
         * 注册异常捕捉
         * 注册之前的报出的异常不能被捕捉
         */
        App::get('exception')->register();
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

    /**
     * @param Server $server
     * @param int $taskId
     * @param int $srcWorkerId
     * @param array $data
     * @return string
     * @author 明月有色 <2206582181@qq.com>
     */
    public function onTask(Server $server,int $taskId,int $srcWorkerId,array $data)
    {

    }

    /**
     * @param Server $server
     * @param int $taskId
     * @param $data
     * @return mixed
     * @author 明月有色 <2206582181@qq.com>
     */
    public function onFinish(Server $server,int $taskId,$data)
    {
        //return $data;
    }
}