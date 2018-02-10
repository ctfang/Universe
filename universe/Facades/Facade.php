<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/10
 * Time: 17:53
 */

namespace Universe\Facades;


use Universe\Exceptions\RuntimeException;

trait Facade
{
    private static $_obj;

    /**
     * @param $_obj
     */
    public static function setFacades($_obj)
    {
        self::$_obj = $_obj;
    }

    abstract public static function getFacadeAccessor();

    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();

        if (! $instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        return $instance->$method(...$args);
    }

    public static function getFacadeRoot()
    {
        return self::$_obj;
    }
}