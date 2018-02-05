<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/1/31
 * Time: 14:07
 */

namespace Universe\Providers;

use Illuminate\Database\Capsule\Manager as Capsule;
use Universe\App;

class DatabaseServerProvider extends AbstractServiceProvider
{
    protected $serviceName = 'db';

    public function register()
    {
        $this->di->set($this->serviceName,function () {
            $capsule = new Capsule();
            $capsule->addConnection( App::get('config')->get('database') );
            $capsule->setAsGlobal();
            $capsule->bootEloquent();
            return $capsule;
        });
    }
}