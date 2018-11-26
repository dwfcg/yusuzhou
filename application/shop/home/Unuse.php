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
// 逻辑更改之后不能使用这个类
class Unuse extends Home
{

    /**
     * 获取单个闲置商品信息
     * id
     */
    public function selectUnuse()
    {
        $data = input('post.');
        $info=Db::name('shop_unuse')
            ->find($data['id']);
        $info['images'] = array_filter(explode(',',$info['images']));
//        dump($info);
        show_api($info);
    }

    /**
     * @page
     * @key
     */
    public function getUnuse(){
        $data = input('post.');
        $limit = 8;
        switch ($data['key'])
        {
            case 'hot':
                $info=Db::name('shop_unuse')
                    ->where('status',4)
                    ->order('add_time desc')
                    ->limit($data['page']*$limit,$limit)
                    ->select();
                break;
            case 'all':
                $info=Db::name('shop_unuse')
                    ->where('status',4)
                    ->limit($data['page']*$limit,$limit)
                    ->select();
                break;
            case 'price':
                $info=Db::name('shop_unuse')
                    ->where('status',4)
                    ->order('price desc')
                    ->limit($data['page']*$limit,$limit)
                    ->select();
                break;
            case 'recommend':
                $info=Db::name('shop_unuse')
                    ->where('status',4)
                   ->where('recommend',1)
                    ->limit($data['page']*$limit,$limit)
                    ->select();
                break;
        }
        foreach ($info as &$goods) {
            $goods['images'] = array_filter(explode(',',$goods['images']));
        }
        show_api($info);
    }
    /*

    * 创建闲置订单
     * 已goods.php下面为准留着备用

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