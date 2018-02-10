<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/10
 * Time: 18:19
 */

namespace Universe\Facades;


use Universe\App;

class LoggerFacade
{
    use Facade;

    public static function getFacadeAccessor()
    {
        return App::getShared('logger');
    }
}