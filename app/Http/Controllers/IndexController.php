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
    /**
     * 测试从路由获取参数id
     */
    public function index()
    {
        return "控制器";
    }

    /**
     * 普通get参数
     */
    public function test()
    {
        $this->response->end( __FILE__.__LINE__ );
    }
}