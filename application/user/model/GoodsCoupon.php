<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/9
 * Time: 14:34
 */

namespace app\user\model;


use think\Model;

class GoodsCoupon   extends Model
{
    public function shopgoods()
    {
        return $this->hasOne('ShopGoods','id','goods_id');
    }
    public function shopCategory()
    {
        return $this->hasOne('ShopCategory','id','goods_category_id');
    }
}