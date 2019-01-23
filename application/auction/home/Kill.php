<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/10
 * Time: 15:13
 */

namespace app\auction\home;


use think\cache\driver\Redis;
use think\Db;
use think\response\Json;

class Kill extends Common
{
    //清除相关抢购商品的redis存储
    public function demo()
    {
        $redis = new Redis();
        $handler=$redis->handler();
        $goods_id=input('goods_id');
        $uid=input('uid');
        $handler->hdel ('order_info:'.$goods_id.'',$uid);
        $handler->srem  ('bought_list:'.$goods_id.'',$uid);
    }
    public function get_arr_column($arr, $key_name)
    {
        $arr2 = array();
        foreach($arr as $key => $val){
            $arr2[] = $val[$key_name];
        }
        return $arr2;
    }
//    商品添加的时候直接操作队列，删除的时候直接pop所有相关数据,初始化队列和删除队列
////    返回数据的时候只给符合条件的数据，拿商品ID和用户ID进行秒杀操作，
/// goods_list.goodsId
/// order_info.goodsId
/// bought_list.goodsId
///
    public function ruhuo($goods_id){
        $redis = new redis();
        $handler=$redis->handler();
//        $goods_id=input('goods_id');
        $redis->lpush('goods_list:'.$goods_id.'',1);
        return $handler->lrange ('goods_list:'.$goods_id.'',0,-1);
    }
//    添加购买成功用户（Set集合）,bought_list确定一人只能秒杀一个商品
    public function redis_qianghuo(){
        $redis = new redis();
//        $redis->clear();
        $handler=$redis->handler();
        $uid=input('uid');
        $goods_id=input('goods_id');
        //查询库存
        $count=$handler->rpop('goods_list:'.$goods_id.'');//检查库存
        if(!$count)
            return json('商品已售完...');
//        //查询是否购买过
        if($handler->sIsMember('bought_list:'.$goods_id.'',$uid))
            return json('已经购买过');
        $handler->sAdd('bought_list:'.$goods_id.'',$uid);//存入购买过的集合
        $value = array(
            'uid'   =>  $uid,
            'goods_id'   =>  $goods_id,
            'time'  =>  time(),
        );
        $handler->hSet('order_info:'.$goods_id.'',$uid,json_encode($value));
        $data=$handler->hgetall('order_info:'.$goods_id.'');
        $newdata=[];
        foreach ($data as $k =>$v)
        {
            $newdata[]=json_decode($v);
        }
//        $newdata=$this->object_array($newdata);
        show_api($newdata,'',1);
//        [138] => array(3) {
//            ["uid"] => string(3) "138"
//            ["goods_id"] => string(4) "1309"
//            ["time"] => int(1539676544)
//  }
    }
    public function object_array($array) {
        if(is_object($array)) {
            $array = (array)$array;
        } if(is_array($array)) {
            foreach($array as $key=>$value) {
                $array[$key] = $this->object_array($value);
            }
        }
        return $array;
    }
//    //秒杀商品列表
//    public function KillData()
//    {
//        $info=Db::name('auction_kill')
//            ->whereTime('start_time', '>=',time())
//            ->where('status',0)
//            ->select();
//        foreach ($info as &$goods) {
//            $goods['images'] = array_filter(explode(',',$goods['imgs']));
//        }
//        show_api($info);
//    }
//    public function Killinfo()
//    {
//        $data=input('post.');
//        $info=Db::name('auction_kill')
//            ->find($data['id']);
//        $info['imgs'] = array_filter(explode(',',$info['imgs']));
//        show_api($info);
//
//    }
    public function end()
    {
        $data=input('post.');
        $update=[
            'status'=>2
        ];
        $rel=Db::name('shop_goods')->find($data['id']);
//        dump($rel);
        if($rel['status']==0)
        {
           return Json::create();
        }
        $info=Db::name('shop_goods')
            ->where('id',$data['id'])->update($update);
        show_api();
    }
}