<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/6
 * Time: 20:17
 */

namespace Universe\Util;


use Universe\App;

class SystemFacade extends \Whoops\Util\SystemFacade
{
    /**
     * @return int
     */
    public function getOutputBufferLevel()
    {
        $level = ob_get_level();
        if( $level==1 ){
            // 如果是最后一层缓冲区，是属于框架的，不关闭
            $level = 0;
        }
        return $level;
    }


    /**
     * @param int $httpCode
     *
     * @return int
     */
    public function setHttpResponseCode($httpCode)
    {
        App::getShared('response')->header('Status Code', $httpCode);
        return 1;
    }

    /**
     * @param int $exitStatus
     */
    public function stopExecution($exitStatus)
    {
        //exit($exitStatus);
    }
}