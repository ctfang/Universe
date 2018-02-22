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
        $session = $this->request->getSession();

        dump($session);
        $session->put('test',date('H:i:s'));

        $data = $session->get('test');

        return $data;

        //$this->response->end($data);

        //return view('welcome')->render();
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