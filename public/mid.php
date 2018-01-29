<?php
/**
 * Created by PhpStorm.
 * User: 89745
 * Date: 2016/12/4
 * Time: 13:56
 */

interface Milldeware {
    public static function handle(Closure $next);
}

class VerfiyCsrfToekn implements Milldeware {

    public static function handle(Closure $next)
    {
        echo '验证csrf Token <br>';
        $next();
    }
}


class ShowErrorsFromSession implements Milldeware {

    public static function handle(Closure $next)
    {
        echo '共享session中的Error变量 <br>';
        $next();
    }
}

class StartSession implements Milldeware {

    public static function handle(Closure $next)
    {
        echo '开启session <br>';
        $next();
        echo '关闭ession <br>';
    }
}

class AddQueuedCookieToResponse implements Milldeware {

    public static function handle(Closure $next)
    {
        $next();
        echo '添加下一次请求需要的cookie <br>';
    }
}

class EncryptCookies implements Milldeware {
    public static function handle(Closure $next)
    {
        echo '解密cookie <br>';
        $next();
        echo '加密cookie <br>';
    }
}

class CheckForMaintenacceMode implements Milldeware {
    public static function handle(Closure $next)
    {
        echo '确定当前程序是否处于维护状态 <br>';
        $next();
    }
}

function getSlice() {
    return function($stack,$pipe) {
        return function() use($stack,$pipe){
            return $pipe::handle($stack);
        };
    };
}


function then() {
    $pipe = [
        'CheckForMaintenacceMode',
        'EncryptCookies',
        'AddQueuedCookieToResponse',
        'StartSession',
        'ShowErrorsFromSession',
        'VerfiyCsrfToekn'
    ];

    $firstSlice = function() {
        echo '请求向路由传递,返回相应 <br>';
    };

    $pipe = array_reverse($pipe);
    $callback = array_reduce($pipe,getSlice(),$firstSlice);

    call_user_func($callback);
}

then();

/**
确定当前程序是否处于维护状态
解密cookie
开启session
共享session中的Error变量
验证csrf Token
请求向路由传递,返回相应
关闭ession
添加下一次请求需要的cookie
加密cookie
 */