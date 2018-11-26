<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/26
 * Time: 11:13
 */

namespace app\user\home;


use app\user\model\UserCart;
use JPush\Client as JPush;
use think\Db;
use app\user\model\User;
//无用
class Cart  extends Common
{
    public function add()
    {
        $data=input('post.');
        $uid=$data['userId'];
        if(Db::name('user_cart')->insert($data))
        {
//            $data=array(), $info='', $code=1
            return show_api('','成功',1);
        }else{
            return show_api('','失败',0);
        }
    }
    public function del()
    {
        $data=input('post.');
        $where=[
            'id'=>$data['id'],
        ];
        if(Db::name('user_cart')->where($where)->delete())
        {
            return show_api('','成功',0);
        }
    }
    public function showCart()
    {
        $data=input('post.');
        $userId=$data['userId'];
        $model=new UserCart();
        $cartDate=$model->cartInfo($userId);
        return show_api($cartDate,'成功',1);
    }
    public function selectCart()
    {
        $data=input('post.');
        $userId=$data['userId'];
        $model=new UserCart();
        $cartDate=$model->selectCartInfo($userId);
        return show_api($cartDate,'成功',1);
    }
    //    搜索信息改动
    public function search()
    {
        $data = input('post.');
        $limit = 10;
        $title = $data['title'];
        $da = ['like','%'.$title.'%'];
//        商品搜索
        $ta['shop_goods'] = Db::name('shop_goods')->where(['title'=>$da])
            ->order('price desc')
            ->field('id,cid,title,tags,price,content,images,video,status,sort,goods_num,shou_num,click_num,com_num,is_free,thoughid,originid,rockid,kindid,weight,size,sku,add_time')
            ->limit($data['page']*$limit,$limit)
            ->select();
        foreach( $ta['shop_goods'] as &$th ){
            $th['images'] = array_filter(explode(',',$th['images']));
            $th['tags'] = array_filter(explode(',',$th['tags']));
            $th['add_time'] = date('Y-m-d H:i',$th['add_time']);
        }
//        用户搜索
        $ta['user'] = Db::name('user')->where(['name'=>$da])
            ->order('id desc')
            ->field('id,name')
            ->limit($data['page']*$limit,$limit)
            ->select();
        foreach( $ta['user'] as $k =>$v ){
            $ta['user'][$k]['face']=Db::name('user_guan')->where('threadid',$ta['user'][$k]['id'])->count();
        }
//        帖子搜索
        $ta['forum_thread'] = Db::name('forum_thread')
            ->where(['sid'=>array('neq',4),'status'=>1,'title'=>$da])
            ->order('flag desc,add_time desc')
            ->field('id,title,conimage,images,type,zan_num,view_num,com_num,add_time')
            ->limit($data['page']*$limit,$limit)
            ->select();
        foreach( $ta['forum_thread'] as &$th ){
            $th['conimage'] = array_filter(explode(',',$th['conimage']));
            $th['images'] = array_filter(explode(',',$th['images']));
            $th['add_time'] = date('Y-m-d H:i',$th['add_time']);
        }
//        dump($ta);
        show_api($ta);
    }
    public function cartInfo()
    {
        $cartData=Db::name('shop_cart')->where('uid',1)->select();
        foreach ($cartData as $k =>$v)
        {
//            dump($cartData[$k]['goods_id']);
            $cartData[$k]['goods']=Db::name('shop_goods')->where('id',$cartData[$k]['goods_id'])->select();
            dump($cartData[$k]['goods'][0]);die();
           $cartData[$k]['goods'][0]['content'] = str_replace("<img "," <img title=\"\" alt=\"\" class=\"lazy\"",$cartData[$k]['goods'][0]['content']);//替换img
//            // print_r($goods['content']);die;
            $cartData[$k]['goods'][0]['images'] = array_filter(explode(',',$cartData[$k]['goods'][0]['images']));

        }
        dump( $cartData);
    }
    //积分商品展示页
    public function goodsInfo(){
//        $data = input('post.');
//        $limit = 8;
        $info['goods']=Db::name('integralshop_index')
            ->order('id asc')
//            ->limit($data['page']*$limit,$limit)
            ->paginate();
        foreach ($info['goods'] as &$goods) {
            $goods['images'] = array_filter(explode(',',$goods['images']));
        }
        dump( $info);
    }
    public function getUnuse(){
        $data = input('post.');
        $limit = 8;
        $info['goods']=Db::name('shop_unuse')
            ->where('status',4)
            ->limit($data['page']*$limit,$limit)
            ->paginate();
        foreach ($info['goods'] as &$goods) {
            $goods['images'] = array_filter(explode(',',$goods['images']));
        }
        show_api($info);
    }
    public function ceshi()
    {
        require    EXTEND_PATH.'JPush/autoload.php';
        $app_key = "d6ecdd4b31d7125d4e009503";
        $master_secret = "83034a219960d7648bd5a8b8";
        $client = new JPush($app_key, $master_secret);
        $result = $client->push()
          ->setPlatform('ios', 'android')
          ->addAllAudience()
          ->setNotificationAlert('Hello, JPush')
          ->options(array(
              "apns_production" => false  //true表示发送到生产环境(默认值)，false为开发环境
          ))
          ->send();
        try {
            $result->send();
        } catch (\JPush\Exceptions\JPushException $e) {
            // try something else here
            print $e;
        }

      echo 'Result=' . json_encode($result);


    }
}