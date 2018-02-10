<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
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
            $config  = App::get('config')->get('database');
            $default = $config['default'];

            $capsule->addConnection( $config['connections'][$default] );

            $capsule->setEventDispatcher( App::get('events') );

            $capsule->setAsGlobal();
            $capsule->bootEloquent();
            return $capsule;
        });
    }
}