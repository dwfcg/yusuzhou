<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/17
 * Time: 14:54
 */

namespace app\shop\home;


use think\Db;

class Comment   extends Common
{
    public function time2string($second){
        $day = floor($second/(3600*24));
        $second = $second%(3600*24);//除去整天之后剩余的时间
        $hour = floor($second/3600);
        $second = $second%3600;//除去整小时之后剩余的时间
        $minute = floor($second/60);
        $second = $second%60;//除去整分钟之后剩余的时间
//返回字符串
        return $day.'天'.$hour.'小时'.$minute.'分'.$second.'秒';
    }
    public function comment()
    {
        $data=input('post.');
        $commentNewData=Db::name('shop_comment')->alias('a')
            ->join("user b","a.uid=b.id")
            ->join("shop_goods c","a.goods_id=c.id")
//            ->join("categorygoods e","e.shopgoods_id=c.id")
//            ->join('shop_category d','e.category_id = d.id')
            ->where('a.goods_id',$data['goods_id'])
            ->where('a.status',1)
//            ->where('goodsstatus',$data['goodsstatus'])
            ->field('a.content,a.goods_id,a.addto,a.images,a.add_time,b.name,b.headimg')
            ->order('a.uid desc')
            ->paginate(10,'',['page'=>$data['page']]);
//        dump($commentNewData->toArray());
        $commentNewData=$commentNewData->toArray();
        foreach ($commentNewData['data'] as &$goods)
        {
            $goods['images'] = array_filter(explode(',',$goods['images']));
//
        }
        $commentNewData['count']=count($commentNewData['data']);
//        $commentNewData=$commentNewData->toArray();
//        dump($commentNewData);
        show_api($commentNewData);
//        dump($commentNewData);
    }
    public function commentTime()
    {
        $data=input('post.');
        $commentNewData=Db::name('shop_comment')->alias('a')
            ->join("user b","a.uid=b.id")
            ->join("shop_goods c","a.goods_id=c.id")
//            ->join('shop_category d','c.cid = d.id')
            ->where('goods_id',$data['goods_id'])
            ->where('goodsstatus',$data['goodsstatus'])
            ->where('addto',0)
            ->where('a.status',1)
            ->order('add_time desc')
            ->field('a.content,a.goods_id,a.addto,a.images,a.add_time,b.name,b.headimg')
            ->paginate(10,'',['page'=>$data['page']]);
        $commentNewData=$commentNewData->toArray();
        foreach ($commentNewData['data'] as &$goods)
        {
            $goods['images'] = array_filter(explode(',',$goods['images']));

        }
        $commentNewData['count']=count($commentNewData['data']);
//        $commentNewData=$commentNewData->toArray();
        show_api($commentNewData);
//        dump($commentNewData);
    }
    public function commentImages()
    {
        $data=input('post.');
        $commentData1=Db::name('shop_comment')->alias('a')
            ->where('goods_id',$data['goods_id'])
            ->where('a.images','not null')
            ->where('a.status',1)
            ->where('goodsstatus',$data['goodsstatus'])
            ->field('a.uid')
            ->select();
        $ids=$this->get_arr_column($commentData1,'uid');
//        dump($ids);
//        dump($data['goods_id']);
        $commentNewData=Db::name('shop_comment')->alias('a')
            ->join("user b","a.uid=b.id")
            ->join("shop_goods c","a.goods_id=c.id")
//            ->join('shop_category d','c.cid = d.id')
            ->where('goods_id',$data['goods_id'])
            ->where('uid','in',$ids)
            ->where('goodsstatus',$data['goodsstatus'])
            ->where('goods_id',$data['goods_id'])
            ->order('a.uid desc')
            ->field('a.content,a.goods_id,a.addto,a.images,a.add_time,b.name,b.id,b.headimg')
            ->paginate(10,'',['page'=>$data['page']]);
        $commentNewData=$commentNewData->toArray();
        foreach ($commentNewData['data'] as &$goods)
        {
            $goods['images'] = array_filter(explode(',',$goods['images']));

        }
        $commentNewData['count']=count($commentNewData['data']);

        show_api($commentNewData);
//        dump($commentNewData);
    }
    public function commentAdd()
    {
        $data=input('post.');
        $commentData=Db::name('shop_comment')->alias('a')
            ->where('goods_id',$data['goods_id'])
            ->where('addto',1)
            ->where('a.status',1)
            ->where('goodsstatus',$data['goodsstatus'])
            ->field('a.uid')
            ->select();
        $ids=$this->get_arr_column($commentData,'uid');
//        dump($ids);
        $commentNewData=Db::name('shop_comment')->alias('a')
            ->join("user b","a.uid=b.id")
            ->join("shop_goods c","a.goods_id=c.id")
//            ->join('shop_category d','c.cid = d.id')
            ->where('goods_id',$data['goods_id'])
            ->where('uid','in',$ids)
            ->where('goodsstatus',$data['goodsstatus'])
            ->order('a.uid desc')
            ->field('a.content,a.goods_id,a.addto,a.images,a.add_time,b.name,b.headimg')
//            ->page(4)
            ->paginate(10,'',['page'=>$data['page']]);
        $commentNewData=$commentNewData->toArray();
        foreach ($commentNewData['data'] as &$goods)
        {
            $goods['images'] = array_filter(explode(',',$goods['images']));

        }
        $commentData['count']=count($commentNewData['data']);

        show_api($commentNewData);
//        dump($commentNewData);
    }
    public function get_arr_column($arr, $key_name)
    {
        $arr2 = array();
        foreach($arr as $key => $val){
            $arr2[] = $val[$key_name];
        }
        return $arr2;
    }
    public function commentadd2()
    {
        $data=input('post.');
        $commentNewData=Db::name('shop_comment')->alias('a')
            ->join("user b","a.uid=b.id")
            ->join("shop_goods c","a.goods_id=c.id")
//            ->join('shop_category d','c.cid = d.id')
            ->where('goods_id',$data['goods_id'])
            ->where('goodsstatus',$data['goodsstatus'])
            ->where('uid',$data['uid'])
            ->where('a.status',1)
            ->where('addto',1)
            ->field('a.content,a.goods_id,a.addto,a.images,a.add_time,b.name,b.headimg')
            ->paginate(10,'',['page'=>$data['page']]);
        $commentNewData=$commentNewData->toArray();
        foreach ($commentNewData['data'] as &$goods)
        {
            $goods['images'] = array_filter(explode(',',$goods['images']));
        }
        $commentNewData['count']=count($commentNewData['data']);
//        $commentNewData=$commentNewData->toArray();
        show_api($commentNewData);
//        dump($commentNewData);
    }
}