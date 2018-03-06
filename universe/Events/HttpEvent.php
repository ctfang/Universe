<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/22
 * Time: 10:21
 */

namespace Universe\Events;

use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;
use Universe\App;
use Universe\Servers\ResponseServer;

class HttpEvent
{
    /**
     * 每个请求执行一次
     *
     * @param Request $sRequest
     * @param Response $sResponse
     * @return ResponseServer
     * @author 明月有色 <2206582181@qq.com>
     */
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
        if( function_exists('opcache_reset') ){
            // 清理 opcache 缓存
            opcache_reset();
        }
        /**
         * 注册异常捕捉
         * 注册之前的报出的异常不能被捕捉
         */
        App::getShared('exception')->register();
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

    /**
     * 请求结束执行
     *
     * @author 明月有色 <2206582181@qq.com>
     */
    public function endRequest()
    {

    }
}