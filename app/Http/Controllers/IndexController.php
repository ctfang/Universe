<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/23
 * Time: 10:52
 */

namespace App\Http\Controllers;


use App\Models\User;
use Universe\Support\DB;

class IndexController extends Controller
{
    /**
     * 浏览器图标请求
     *
     * @author 明月有色 <2206582181@qq.com>
     */
    public function favicon()
    {
        $this->response->end("OK");
    }

    public function getString()
    {
        return '输出字符串;获取请求参数:' . $this->request->get('id', 'int', 0);
    }

    public function getJson()
    {
        return [
            'time'   => time(),
            'string' => '响应json格式，自动加Json Header',
        ];
    }

    /**
     * 首页
     */
    public function index()
    {
        throw new \Exception('测试、调试错误');
    }
}