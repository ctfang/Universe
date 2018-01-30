<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/23
 * Time: 10:52
 */

namespace App\Http\Controllers;


class IndexController extends Controller
{
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

    }

    /**
     * 普通get参数
     */
    public function test()
    {
        $this->response->end( __FILE__.__LINE__ );
    }
}