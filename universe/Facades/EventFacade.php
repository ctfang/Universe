<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/11
 * Time: 11:12
 */

namespace Universe\Facades;


use Universe\App;

class EventFacade
{
    use Facade;

    public static function getFacadeAccessor()
    {
        return App::getShared('events');
    }
}