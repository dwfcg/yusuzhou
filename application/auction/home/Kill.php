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

class Kill extends Common
{
    public function demo()
    {
        $redis = new Redis();
        $redis->set('test','hello redis');
        echo $redis->get('test');
    }
    public function get_arr_column($arr, $key_name)
    {
        $arr2 = array();
        foreach($arr as $key => $val){
            $arr2[] = $val[$key_name];
        }
        return $arr2;
    }
    public function ruhuo(){
        $redis = new redis();
        $goods_id=input('goods_id');
        $redis->lpush('goods_list:'.$goods_id.'',1);
        echo '进货成功';
    }
    public function redis_qianghuo(){
        $redis = new redis();
//        $redis->clear();
        $handler=$redis->handler();
        $uid=input('uid');
        $goods_id=input('goods_id');
        //查询库存
        $count=$handler->rpop('goods_list:'.$goods_id.'');
        if(!$count)
            return json('商品已售完...');
//        //查询是否购买过
        $value = array(
            'uid'   =>  $uid,
            'goods_id'   =>  $goods_id,
            'time'  =>  time(),
        );
        $handler->hSet('order_info',$uid,json_encode($value));
        $data=$handler->hgetall('order_info');
        $newdata=[];
        foreach ($data as $k =>$v)
        {
            $newdata[$k]=json_decode($v);
        }
        $newdata=$this->object_array($newdata);
        dump($newdata);
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
}