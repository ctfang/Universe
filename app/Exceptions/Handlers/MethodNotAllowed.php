<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/5
 * Time: 14:20
 */

namespace App\Exceptions\Handlers;


use Universe\Exceptions\Handlers\Handler;

class MethodNotAllowed extends Handler
{
    /**
     * 异常处理
     *
     * 405路由处理，当前的dump打印在命令行
     * 跨域请求，如果信任，返回信息头，允许请求
     *
     * @return bool false 终止
     */
    public function handle()
    {
        // TODO: Implement handle() method.
    }
}