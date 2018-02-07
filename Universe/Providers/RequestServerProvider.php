<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/7
 * Time: 12:47
 */

namespace Universe\Providers;


use Universe\Servers\RequestServer;

class RequestServerProvider extends AbstractServiceProvider
{
    protected $serviceName = 'request';

    public function register()
    {
        $this->di->set($this->serviceName,function (){
            return new RequestServer();
        });
    }
}