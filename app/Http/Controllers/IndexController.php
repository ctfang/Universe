<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/23
 * Time: 10:52
 */

namespace App\Http\Controllers;


use think\Db;
use think\db\connector\Mysql;
use think\db\Query;
use Universe\App;

class IndexController extends Controller
{
    public static $test = 0;
    public function getString()
    {
        return '输出字符串;获取请求参数:'.$this->request->get('id','int',0);
    }

    public function getJson()
    {
        return [
            'time'=>time(),
            'string'=>'响应json格式，自动加Json Header',
        ];
    }

    /**
     * 测试从路由获取参数id
     */
    public function index()
    {
        $db = App::getDi()->get('db');

        $data = $db::query('SHOW full PROCESSLIST');

        dump($data);

        self::$test++;
        return '首页'.self::$test;
    }

    public function test()
    {
        dump("OK");
    }
}