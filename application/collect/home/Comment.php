<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/18
 * Time: 10:36
 */

namespace app\collect\home;

use think\Db;
class Comment   extends Common
{
    public function comment()
    {
        $data=input('post.');
        $commentNewData=Db::name('shop_comment')->alias('a')
            ->join("user b","a.uid=b.id")
            ->join("collect_good c","a.collect_id=c.id")
            ->join('collect_category d','c.cid = d.id')
            ->where('collect_id',$data['collect_id'])
            ->where('goodsstatus',$data['goodsstatus'])
//            ->field('a.content,a.collect_id,a.addto,a.images,a.add_time,b.name,b.headimg,d.name as cname')
            ->order('a.uid desc')
            ->paginate(10,'',['page'=>$data['page']]);
        foreach ($commentNewData as &$goods)
        {
            $goods['images'] = array_filter(explode(',',$goods['images']));
        }
        $commentNewData['count']=count($commentNewData);
        $commentNewData=$commentNewData->toArray();
        show_api($commentNewData);
//        dump($commentNewData);
    }
    public function commentTime()
    {
        $data=input('post.');
        $commentNewData=Db::name('shop_comment')->alias('a')
            ->join("user b","a.uid=b.id")
            ->join("collect_good c","a.collect_id=c.id")
            ->join('collect_category d','c.cid = d.id')
            ->where('collect_id',$data['collect_id'])
            ->where('goodsstatus',$data['goodsstatus'])
            ->order('add_time desc')
            ->field('a.content,a.collect_id,a.addto,a.images,a.add_time,b.name,b.id,b.headimg,d.name as cname')
            ->paginate(10,'',['page'=>$data['page']]);
        foreach ($commentNewData as &$goods)
        {
            $goods['images'] = array_filter(explode(',',$goods['images']));
        }
        $commentNewData['count']=count($commentNewData);
        $commentNewData=$commentNewData->toArray();
        show_api($commentNewData);
//        dump($commentNewData);
    }
    public function commentImages()
    {
        $data=input('post.');
        $commentData1=Db::name('shop_comment')->alias('a')
            ->where('collect_id',$data['collect_id'])
            ->where('a.images','not null')
            ->where('goodsstatus',$data['goodsstatus'])
            ->field('a.uid')
            ->select();
        $ids=$this->get_arr_column($commentData1,'uid');
//        dump($ids);
        $commentNewData=Db::name('shop_comment')->alias('a')
            ->join("user b","a.uid=b.id")
            ->join("collect_good c","a.collect_id=c.id")
            ->join('collect_category d','c.cid = d.id')
            ->where('collect_id',$data['collect_id'])
            ->where('uid','in',$ids)
            ->where('goodsstatus',$data['goodsstatus'])
            ->order('a.uid desc')
            ->field('a.content,a.collect_id,a.addto,a.images,a.add_time,b.name,b.id,b.headimg,d.name as cname')
            ->paginate(10,'',['page'=>$data['page']]);
        foreach ($commentNewData as &$goods)
        {
            $goods['images'] = array_filter(explode(',',$goods['images']));
        }
        $commentNewData['count']=count($commentNewData);
        $commentNewData=$commentNewData->toArray();
        show_api($commentNewData);
//        dump($commentNewData);
    }
    public function commentAdd()
    {
        $data=input('post.');
        $commentData=Db::name('shop_comment')->alias('a')
            ->where('collect_id',$data['collect_id'])
            ->where('addto',1)
            ->where('goodsstatus',$data['goodsstatus'])
            ->field('a.uid')
            ->select();
        $ids=$this->get_arr_column($commentData,'uid');
        $commentNewData=Db::name('shop_comment')->alias('a')
            ->join("user b","a.uid=b.id")
            ->join("collect_good c","a.collect_id=c.id")
            ->join('collect_category d','c.cid = d.id')
            ->where('collect_id',$data['collect_id'])
            ->where('uid','in',$ids)
            ->where('goodsstatus',$data['goodsstatus'])
            ->order('a.uid desc')
            ->field('a.content,a.goods_id,a.addto,a.images,a.add_time,b.name,b.headimg,d.name as cname')
            ->page(4)
            ->paginate(10,'',['page'=>$data['page']]);
        foreach ($commentNewData as &$goods)
        {
            $goods['images'] = array_filter(explode(',',$goods['images']));
        }
        $commentData['count']=count($commentNewData);
        $commentNewData=$commentNewData->toArray();
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
}