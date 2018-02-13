<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/12
 * Time: 10:23
 */

namespace Universe\Providers;


use Philo\Blade\Blade;

class ViewServerProvider extends AbstractServiceProvider
{
    protected $serviceName = 'view';

    public function register()
    {
        $this->di->set($this->serviceName,function (){
            $views = root_path('/public/views');
            $cache = storage_path('/framework/views');

            $blade = new Blade($views, $cache);

            return $blade->view();
        });
    }
}