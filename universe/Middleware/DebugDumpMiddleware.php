<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/31
 * Time: 15:28
 */

namespace Universe\Middleware;


use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;
use Universe\Servers\RequestServer;
use Universe\Support\Middleware;

class DebugDumpMiddleware extends Middleware
{
    /**
     * 调试模式下所有输出都在缓冲区
     *
     * @param RequestServer $request
     * @param $next
     */
    public function handle(RequestServer $request, $next)
    {
        if( is_debug() ){
            // 如果调试开始，注册打印函数
            VarDumper::setHandler(function ($var) {
                $cloner = new VarCloner();
                $dumper = new HtmlDumper();
                $dumper->dump($cloner->cloneVar($var));
            });
        }

        return $next($request);
    }
}