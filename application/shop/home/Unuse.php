<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/28
 * Time: 11:37
 */

namespace app\shop\home;


use app\index\controller\Home;
use think\Db;

class Unuse extends Home
{
//    闲置商品展示页
    public function getUnuse(){
        $data = input('post.');
        $limit = 8;
        $info['goods']=Db::name('shop_unuse')
            ->where('status',4)
            ->limit($data['page']*$limit,$limit)
            ->select();
        foreach ($info['goods'] as &$goods) {
            $goods['images'] = array_filter(explode(',',$goods['images']));
        }
//        dump($info);
        show_api($info);
    }
    /*

    * 创建闲置订单

    */

    public function create_order(){

        $data = input('post.');

        $address_id = input('address_id');

        $region = AddressModel::where( 'address_id',$address_id )->find();

        if( !$region || !$region['address'] || !$region['sheng'] || !$region['shi'] || !$region['xian']){

            $this->result(0,'address');

        }

        $goods_id = explode(',',$data['goods_id']);

        $goods = Db::name('shop_unuse')->where('id','in',$goods_id)->select();
        // dump($goods);die;
        $order['unuse_id'] = $data['goods_id'];

        $order['address_id'] = $address_id;

        // $order['user_id'] = $this->user['id'];
        $order['user_id'] = input('post.uid');
        $order['price'] = array_sum(array_column($goods,'price'));

        $order['add_time'] = time();

        $order['address'] = $region['address'];

        $order['consignee'] = $region['consignee'];

        $order['mobile'] = $region['mobile'];

        $order['province'] = $region['province'];

        $order['city'] = $region['city'];

        $order['district'] = $region['district'];

        $order['province_name'] = $region['sheng'];

        $order['city_name'] = $region['shi'];

        $order['district_name'] = $region['xian'];
        $order['order_status'] = 1;

        Db::startTrans();

        $orderid = DB::name('shop_order')->insertGetId( $order );

        $update['order_sn'] = time().$orderid;

        DB::name('shop_order')->where( 'id',$orderid )->update($update);
        if( $orderid ){
            Db::commit();
            $this->result($orderid);
        }else{
            Db::rollback();
            $this->result(0,2);
        }
    }

}