<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/26
 * Time: 11:15
 */

namespace app\user\model;


use think\Model;

class UserCart  extends Model
{
    public function cartInfo($userId)
    {
        return self::where('userId',$userId)->select();
    }
    public function selectCartInfo($userId)
    {
        return self::where('userId',$userId)->where('staus',1)->select();
    }
}