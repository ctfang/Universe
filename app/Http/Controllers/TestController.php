<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/3/6
 * Time: 11:19
 */

namespace App\Http\Controllers;


class TestController extends Controller
{
    /**
     * @get('/test')
     * @author 明月有色 <2206582181@qq.com>
     */
    public function index()
    {
        dump("test");
    }

    /**
     * @get('/test/get')
     * @author 明月有色 <2206582181@qq.com>
     */
    public function test()
    {
        dump($this);
    }
}