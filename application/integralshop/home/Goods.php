<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/28
 * Time: 11:08
 */
namespace app\integralshop\home;
use app\index\controller\Home;
use think\Db;
use app\shop\model\Region as RegionModel;

use app\shop\model\Address as AddressModel;

class Goods extends Home
{
    //积分商品展示页
    public function goodsInfo(){
        $data = input('post.');
        $limit = 8;
        $info=Db::name('integralshop_index')
            ->order('id asc')
//            ->limit($data['page']*$limit,$limit)
            ->paginate(10,'',['page'=>$data['page']]);
        foreach ($info as &$goods) {
            $goods['images'] = array_filter(explode(',',$goods['images']));
        }
//        dump($info);
        show_api($info);
    }
    //处理用户积分购买订单ID及所属种类实物还是红包

    /**
     * @uid
     * @orderId订单ID
     *@status 实物or红包
     *
     */
    public function payintegral(){
        $data=input('post.');
        $rel=Db::name('user')->where('id',$data['uid'])->find();
        $orderintegral=Db::name('user_integral')->where('id',$data['orderId'])->find();
        $price=$rel['integral']-$orderintegral['price'];
        if(is_int($price))
        {
            Db::startTrans();
            $shopdata=Db::name('integralshop_index')->where('id',$orderintegral['integralshop_id'])->find();
            if($shopdata['num']==0){
                show_api('','已经被兑换完','0');
            }
            Db::name('integralshop_index')->where('id',$orderintegral['integralshop_id'])->setDec('num');
            Db::name('user')->where('id',$data['uid'])->update(['integral'=>$price]);
            if($data['status']==1)
            {
//                购买红包处理
//                $money=$rel['wallet']+$shopdata['money'];
                Db::name('user')->where('id',$data['uid'])->setInc('wallet',$shopdata['money']);

                Db::name('user_integral')->where('id',$data['orderId'])->update(['status'=>3]);

            }else{
                // 购买实物处理
                Db::name('user_integral')->where('id',$data['orderId'])->update(['status'=>1]);
            }
            Db::commit();
            show_api('','兑换成功','1');
        }else{
            Db::rollback();
            show_api('','积分不足','0');
        }



    }
    //积分商品详情页商品ID
    public function integralshopInfo()
    {
        $data=input('post.');
        $rel=Db::name('integralshop_index')->where('id',$data['id'])->find();
        $rel['images']=array_filter(explode(',',$rel['images']));
//        dump($rel);
        show_api($rel);
    }

    /**
     *  创建积分订单
     * @uid
     * @address_id
     * @goods_id
     */
    public function create_order(){

        $data = input('post.');

        $address_id = input('address_id');


        $region = AddressModel::where( 'address_id',$address_id )->find();

        if( !$region || !$region['address'] || !$region['sheng'] || !$region['shi'] || !$region['xian']){

           show_api(0,'address');

        }

        $goods_id = explode(',',$data['goods_id']);
//        dump($goods_id);
        $goods = Db::name('integralshop_index')->where('id','in',$goods_id)->select();
//         dump($goods);die;
        $order['integralshop_id'] = $data['goods_id'];

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

        Db::startTrans();

        $orderid = DB::name('user_integral')->insertGetId( $order );

        $update['order_no'] = time().$orderid;

        DB::name('user_integral')->where( 'id',$orderid )->update($update);

        if( $orderid ){
            Db::commit();
            $goods['orderid']=$orderid;
//            dump($goods);
            show_api($goods);
        }else{
            Db::rollback();
            show_api(0,2);
        }
    }
//    //积分订单展示页 订单ID
//    public function getOrderInfo()
//    {
//        $data=input('post.');
//        $rel=Db::name('user_integral')->where('id',$data['id'])->find();
//        $relshop=Db::name('integralshop_index')->where('id',$rel['integral_id'])->find();
//    }
    public function makeOrderNo()
    {
        $code = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');

        $osn = $code[intval(date('Y')) - 2011]
            . strtoupper(dechex(date('m'))) . date('d')
            . substr(time(), -5) . substr(microtime(), 2, 5)
            . sprintf('%02d', rand(0, 99));
        return $osn;
    }
    /**
     * 获取用户积分订单信息
     * @UID
     * @page
     */
    public function getIntegtalOrder()
    {
        $data = input('post.');
        $limit = 8;
        $info=Db::name('user_integral')->alias('a')
            ->join("integralshop_index b","a.integralshop_id=b.id")
            ->where('user_id',$data['uid'])
            ->order('add_time desc')
            ->field('a.*,b.images,b.status as shopstatus,b.price,b.money,b.comment,b.name')
            ->paginate(10,'',['page'=>$data['page']]);
        foreach ($info as &$goods) {
            $goods['images'] = array_filter(explode(',',$goods['images']));
        }
//        dump($info);
        show_api($info);

    }
    /**
     * @uid
     * @orderid
     */
    public function recive()
    {
        $data=input('post.');
        $info=Db::name('user_integral')->where('user_id',$data['uid'])->where('id',$data['orderid'])->find();
        if(!$info)
        {
            show_api('','请仔细检查订单','0');
        }
        Db::name('user_integral')->where('id',$data['orderid'])->where('')->update(['status'=>3]);
        show_api('','订单已完成','0');
    }
}