<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/26
 * Time: 20:00
 */

namespace Universe\Providers;

use Universe\Exceptions\Handlers\LoggerHandler;
use Universe\Servers\ExceptionServer;

class ExceptionServerProvider extends AbstractServiceProvider
{
    protected $serviceName = 'exception';

    public function register()
    {
        $this->di->set($this->serviceName,function (){
            $Exception = new ExceptionServer();
            // 日记处理
            $Exception->pushHandler(new LoggerHandler());
            return $Exception;
        });
    }
}