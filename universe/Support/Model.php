<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/5
 * Time: 17:11
 */

namespace Universe\Support;


use Universe\App;

class Model extends \Illuminate\Database\Eloquent\Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}