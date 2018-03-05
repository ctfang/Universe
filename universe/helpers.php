<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/10/8
 * Time: 上午12:08
 */


use Universe\App;

if (!function_exists('env')) {
    /**
     * @param      $key
     * @param null $default
     * @return array|bool|false|null|string
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        if (strlen($value) > 1 && \Universe\Util\Str::startsWith($value, '"') && \Universe\Util\Str::endsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}

if (! function_exists('database_path')) {
    /**
     * Get the database path.
     *
     * @param  string  $path
     * @return string
     */
    function database_path($path = '')
    {
        return \Universe\App::getPath('/database').$path;
    }
}

if (! function_exists('storage_path')) {
    /**
     * Get the storage path.
     *
     * @param  string  $path
     * @return string
     */
    function storage_path($path = '')
    {
        return \Universe\App::getPath('/storage').$path;
    }
}

if (! function_exists('root_path')) {
    /**
     * Get the storage path.
     *
     * @param  string  $path
     * @return string
     */
    function root_path($path = '')
    {
        return \Universe\App::getPath().$path;
    }
}

if (! function_exists('is_debug')) {
    /**
     * 判断时候调试模式
     *
     * @return mixed
     * @author 明月有色 <2206582181@qq.com>
     */
    function is_debug()
    {
        if( !defined('IS_DEBUG') ){
            define('IS_DEBUG',\Universe\App::getDi()->get('config')->get('debug',false));
        }
        return IS_DEBUG;
    }
}


if (! function_exists('view')) {
    /**
     * @param $file
     * @return mixed
     * @author 明月有色 <2206582181@qq.com>
     */
    function view($file)
    {
        return App::get('view')->make($file);
    }
}