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
     * 首页
     */
    public function index()
    {
        //\Cache::set('test','ttttt');

        dump(\Cache::get('test'));
        //throw new \Exception('测试、调试错误');
    }

    /**
     * 浏览器图标请求
     *
     * @author 明月有色 <2206582181@qq.com>
     */
    public function favicon()
    {
        $this->response->end("OK");
    }

    /**
     * 字符串输出
     *
     * @return string
     * @author 明月有色 <2206582181@qq.com>
     */
    public function getString()
    {
        return '输出字符串;获取请求参数:' . $this->request->get('id', 'int', 0);
    }

    /**
     * json返回
     *
     * @return array
     * @author 明月有色 <2206582181@qq.com>
     */
    public function getJson()
    {
        return [
            'time'   => time(),
            'string' => '响应json格式，自动加Json Header',
        ];
    }
}