<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/22
 * Time: 9:46
 */

namespace Universe\Providers;


use Universe\App;
use Universe\Servers\HttpServer;

class HttpServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'http';

    public function register()
    {
        $this->di->set($this->serviceName,function (){
            $server = App::getDi()->getShared('config')->get('server');
            return new HttpServer($server['host'],$server['port']);
        });
    }
}