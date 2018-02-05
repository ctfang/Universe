<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/5
 * Time: 17:11
 */

namespace Universe\Support;


use Universe\App;

class Model extends \Illuminate\Database\Eloquent\Model
{
    public function __construct(array $attributes = [])
    {
        App::getShared('db');
        parent::__construct($attributes);
    }
}