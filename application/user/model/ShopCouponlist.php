<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/9
 * Time: 14:28
 */

namespace app\user\model;


use think\Model;

class ShopCouponlist extends Model
{
    public function coupon()
    {
        return $this->hasOne('ShopCoupon','id','cid');
    }
}