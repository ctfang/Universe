<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/10
 * Time: 17:59
 */

namespace Universe\Servers;


use Universe\Facades\Facade;

class FacadeService
{
    protected $alias;

    public function __construct($alias)
    {
        $this->alias = $alias;
    }

    public function getFacades()
    {
        return $this->alias;
    }

    public function register()
    {
        foreach ($this->alias as $alias=>$server){
            class_alias($server,$alias);
            $class = $server::getFacadeAccessor();
            if( is_object($class) ){
                $server::setFacades($class);
            }else{
                $server::setFacades(new $class());
            }
        }
    }
}