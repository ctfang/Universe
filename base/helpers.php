<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/10/8
 * Time: 上午12:08
 */

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;
use Universe\Tool\Str;

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

        if (strlen($value) > 1 && Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}


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

        if( IS_DEBUG ){
            // 如果调试开始，注册打印函数
            VarDumper::setHandler(function ($var) {
                $cloner = new VarCloner();
                $dumper = new HtmlDumper();
                $dumper->dump($cloner->cloneVar($var));
            });
        }
    }
    return IS_DEBUG;
}
