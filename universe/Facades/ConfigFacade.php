<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/12
 * Time: 10:28
 */

namespace Universe\Facades;


use Universe\App;

class ConfigFacade
{
    use Facade;

    public static function getFacadeAccessor()
    {
        return App::getShared('config');
    }
}