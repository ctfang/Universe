<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/10
 * Time: 17:52
 */

namespace Universe\Facades;


use Universe\App;

class DatabaseFacade
{
    use Facade;

    public static function getFacadeAccessor()
    {
        return App::getShared('db');
    }
}