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
     *
     * @param $id
     */
    public function index($id)
    {
        $this->response->end($id);
    }

    /**
     * 普通get参数
     */
    public function test()
    {
        $this->response->end( __FILE__.__LINE__ );

    }
}