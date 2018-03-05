<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/5
 * Time: 17:10
 */

namespace App\Models;


use Universe\Support\Model;

class User extends Model
{
    protected $table = 'users';

    public function password($password)
    {
        return md5(base64_encode($password));
    }
}