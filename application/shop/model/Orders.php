<?php

// +----------------------------------------------------------------------

// | 海豚PHP框架 [ DolphinPHP ]

// +----------------------------------------------------------------------

// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]

// +----------------------------------------------------------------------

// | 官方网站: http://dolphinphp.com

// +----------------------------------------------------------------------

// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )

// +----------------------------------------------------------------------



namespace app\shop\model;



use think\Model as ThinkModel;

use think\Db;

/**

 * 订单模型

 * @package app\cms\model

 */

class Orders extends ThinkModel

{

    // 设置当前模型对应的完整数据表名称

    protected $table = '__SHOP_ORDER__';



    // 自动写入时间戳

    protected $autoWriteTimestamp = true;

    //订单列表

    public static function  getOrders($where,$start=0,$limilt=10){

        

        $count = Db::name('shop_order')->where($where)->count();
// var_dump($count);
        
         $orders = Db::name('shop_order')->where($where)->order('add_time desc')->select();
        // $orders = Db::name('shop_order')->where($where)->limit($start,$limilt)->select();
// var_dump($orders);die;
        foreach ($orders as &$row){

            $goods = Db::name('shop_goods')->find($row['goods_id']);

       

            $row['title'] = $goods['title'];

            

            $imgs = explode(",", $goods['images']);

            $row['pic'] = $imgs[0];     

        }  

    

        // $orders['count'] = ceil($count/$limilt);
$orders['count'] = $count;
        return $orders;

    }

    

    // 订单详情

    public static function  get_one($id){

       // 

        $detial = Db::name('shop_order')->find($id);

        $shop_goods = Db::name('shop_goods')->find($detial['goods_id']);

             

        $detial['title'] = $shop_goods['title'];

        $imgs = explode(",", $shop_goods['images']);



        $detial['pic'] = $imgs[0];              

        return $detial;

    }

    

  

}