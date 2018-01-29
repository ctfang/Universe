<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/1/29
 * Time: 13:56
 */

namespace Universe\Providers;


use Universe\Servers\ConfigServer;

class ConfigServerProvider extends AbstractServiceProvider
{
    protected $serviceName = 'config';

    public function register()
    {
        $this->di->set($this->serviceName,function (){
            return new ConfigServer();
        });
    }
}