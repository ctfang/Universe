<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/11
 * Time: 16:31
 */

namespace Universe\Facades;


use Universe\App;

class CacheFacade
{
    use Facade;

    public static function getFacadeAccessor()
    {
        return App::getShared('cache');
    }
}