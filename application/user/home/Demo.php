<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/10
 * Time: 9:49
 */

namespace app\user\home;


use app\index\controller\Home;
//use think\session\driver\Redis;
use think\cache\driver\Redis;

//这就是个测试redis
class Demo extends Common
{
    public function demo()
    {
        $redis = new Redis();
        $redis->set('test','hello redis');
        echo $redis->get('test');
    }
    public function ruhuo(){
        $redis = new redis();
        for($i = 1;$i<=1000;$i++)
            $redis->lpush('goods_list',$i);
        echo '进货成功';
    }
    public function redis_qianghuo(){
        $redis = new redis();
//        $redis->clear();
        $handler=$redis->handler();
        $uid=input('uid');
        //查询库存
        if($handler->lLen('goods_list') == 0)
            return json('商品已售完...');
        //查询是否购买过

        if($handler->sIsMember('bought_list',$uid))
            return json('你已经购买过了!');
        $goods_id = $handler->rpop('goods_list');
        $handler->sAdd('bought_list',$uid);
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