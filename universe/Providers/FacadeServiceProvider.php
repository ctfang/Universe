<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/10
 * Time: 17:42
 */

namespace Universe\Providers;


use Universe\Servers\FacadeService;

class FacadeServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'facade';

    public function register()
    {
        $this->di->set($this->serviceName,function (){
            return new FacadeService($this->aliases);
        });
    }
}