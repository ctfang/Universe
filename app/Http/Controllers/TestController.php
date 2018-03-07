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
    public function tets()
    {
        \Log::info(date('Y-m-d H:i:s'));
        return $this->view('welcome')->render();
    }

    /**
     * 冒泡排序
     *
     * @get('/maopao')
     */
    public function index()
    {
        $data = [4,5,2,6,8,6,4,1,2,32];

        for($i=0;$i<count($data);$i++){
            for($j=$i+1;$j<count($data);$j++){
                if( $data[$i]>$data[$j] ){
                    list($data[$i],$data[$j]) = [$data[$j],$data[$i]];
                }
            }
        }
        dump($data);
    }

    /**
     * 选择排序
     * 
     * @get('/xuanze')
     */
    public function xuanze()
    {
        $data = [4,5,2,6,8,6,4,1,2,32];

        for($i=0;$i<count($data);$i++){
            for($j=$i+1;$j<count($data);$j++){
                if( $data[$i]>$data[$j] ){
                    list($data[$i],$data[$j]) = [$data[$j],$data[$i]];
                }
            }
        }
        dump($data);
    }

    /**
     * @get('/kuaisu')
     * @author 明月有色 <2206582181@qq.com>
     */
    public function kuaisu()
    {
        dump('123');
    }
}