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



namespace app\shop\home;

use think\Db;
use think\Cache;
/**

 * 前台首页控制器

 * @package app\forum\thread

 */

class Index extends Common

{
    protected function _initialize()
    {
        header('content-type:text/html;charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET, POST, PUT');
        ksort($_POST);
        ksort($_GET);
    }
    /**
     * 获取信息
     * @author Lieber
     * @return mixed
     */
    public function getInfo()
    {
        $oroderby = 'sort asc';
        $info['slider'] = Db::name('shop_slider')->where('status',1)->order($oroderby)->field('id,title,img,url')->select();
        $info['cates'] = Db::name('shop_category')->where(['status'=>1,'pid'=>['neq',0]])->order($oroderby)->field('id,pid,name,icon,sort,status,tuijian,update_time')->select();
        show_api($info);
    }
    //获取图
    public function getTu()
    {
        $info['tu'] = Db::name('shop_tu')->where('status',1)->order('sort asc')->field('id,name,img,link')->select();
        show_api($info);
    }
    /**
     * 获取分类
     * @author Lieber
     * @return mixed
     */
    public function getCate()
    {
        $id = input('id');
        $oroderby = 'sort asc';
        if( $id ){
            $info['child'] = Db::name('shop_category')->where(['status'=>1,'pid'=>$id])->order($oroderby)->field('id,pid,name,icon,sort,status,tuijian,update_time')->select();
        }else{
            $info['first'] = Db::name('shop_category')
                            ->where(['status'=>1,'pid'=>0])
                            ->order($oroderby)
                            ->field('id,pid,name,icon,sort,status,tuijian,update_time')
                            ->select();
            $info['child'] = Db::name('shop_category')->where(['status'=>1,'pid'=>$info['first'][0]['id']])->order($oroderby)->field('id,pid,name,icon,sort,status,tuijian,update_time')->select();
        }
        show_api($info);
    }
    /**
     * 获取信息
     * @author Lieber
     * @return mixed
     */
    public function getGoodsList()
    {
        $data = input('post.');
        $limit = 10;
        // $data['page'] = 0;
        $map['status'] = array('eq',1);
        if( isset($data['cid']) ){
            $map['cid'] = $data['cid'];
        }
        if(isset($data['price'])){
            if($data['price'] === '80000以上'){
                $price=substr($data['price'],0,5);
                $map['price'] = ['>=',$price];
            }else{
                $price = explode('-',$data['price']);
                $map['price'] = [['>=',$price[0]],['<=',$price[1]]];
            }
        }
        $info['goods'] = Db::name('shop_goods')->where($map)->field('id,cid,title,tags,price,content,images,video,status,sort,goods_num,shou_num,click_num,com_num,is_free,thoughid,originid,rockid,kindid,weight,size,sku,add_time')->order('sort asc')->limit($data['page']*$limit,$limit)->select();
        // var_dump($info);die;
        foreach( $info['goods'] as &$goods ){
            $goods['images'] = array_filter(explode(',',$goods['images']));

            $goods['tags'] = array_filter(explode(',',$goods['tags']));
        }
        show_api($info);
    }
    /*
     * 商品搜索
     * 
     * author  su
    */
    public function search()
    {
        $data = input('post.');
        $limit = 10;
        $title = $data['title'];
        $da = ['like','%'.$title.'%'];
        $ta['search'] = Db::name('shop_goods')->where(['title'=>$da])
                ->order('price desc')
                ->field('id,cid,title,tags,price,content,images,video,status,sort,goods_num,shou_num,click_num,com_num,is_free,thoughid,originid,rockid,kindid,weight,size,sku,add_time')
                ->limit($data['page']*$limit,$limit)
                ->select();
        foreach( $ta['search'] as &$th ){
            $th['images'] = array_filter(explode(',',$th['images']));
            $th['tags'] = array_filter(explode(',',$th['tags']));
            $th['add_time'] = date('Y-m-d H:i',$th['add_time']);
        }
           if (empty($ta['search'])) {
               show_api($ta,'暂无参数',0);
           }
        show_api($ta);

    }

    /*
     * 获取商品类型
     * time: 4月21日11点
     * author  su
    */
   
   public function getGoodsDing()
   {
        $data = input('post.');
        // $data['page'] = 0;
        $limit = 8;
        $data['add_time'] = date("Y-m-d H:i");
        $timing = Db::name('shop_goods')->where(['status'=>3])->field('id,title,price,images,video,status,ding_time')->select();
        foreach ($timing as $key => $v) {
            if ($v['ding_time'] != $data['add_time']) {
                $info['goods'] = Db::name('shop_goods')->where(['status'=>3])
                    ->order('price desc')
                    ->field('id,cid,title,tags,price,content,images,video,status,ding_time,sort,goods_num,shou_num,click_num,com_num,is_free,thoughid,originid,rockid,kindid,weight,size,sku,add_time')
                    ->limit($data['page']*$limit,$limit)
                    ->select();
                foreach ($info['goods'] as &$goods) {
                   $goods['images'] = array_filter(explode(',',$goods['images']));
                   $goods['tags'] = array_filter(explode(',',$goods['tags']));
                }
                show_api($info,'定时发布',2);
            }else if ($v['ding_time'] >= $data['add_time']){
                $info = Db::name('shop_goods')->where(['ding_time'=>$v['ding_time']])->update(['status'=>1]);
                show_api($info,'暂无新上',1);
            }

    }
   }
   //全部
   public function getGoodsQuan()
   {
        $data = input('post.');
        $limit = 8;
        $info['goods'] = Db::name('shop_goods')->where(['status'=>1])
                ->order('price desc')
                ->field('id,cid,title,tags,price,content,images,video,status,sort,goods_num,shou_num,click_num,com_num,is_free,thoughid,originid,rockid,kindid,weight,size,sku,add_time')
                ->limit($data['page']*$limit,$limit)
                ->select();
        foreach ($info['goods'] as &$goods) {
           $goods['images'] = array_filter(explode(',',$goods['images']));
           $goods['tags'] = array_filter(explode(',',$goods['tags']));
       }
       show_api($info);
   }
    //每周新上1
    public function  getGoodsXin()
    {
        $data = input('post.');
        $limit = 8;
        //此方法返回一个对象数组，所以要使用数据也必须转换，当然可以直接用对象
        $info['goods'] = Db::name('shop_goods')
                ->where(['status'=>1])
                ->order('add_time desc')
                ->field('id,cid,title,tags,price,content,images,video,status,sort,goods_num,shou_num,click_num,com_num,is_free,thoughid,originid,rockid,kindid,weight,size,sku,add_time')
                ->limit($data['page']*$limit,$limit)
                ->select();
        foreach( $info['goods'] as &$goods ){
            $goods['images'] = array_filter(explode(',',$goods['images']));
            $goods['tags'] = array_filter(explode(',',$goods['tags']));
        }
        show_api($info);
    }
    //已结缘0
    public function getGoodsYi()
    {
        $data = input('post.');
        $limit = 8;
        $info['goods'] = Db::name('shop_goods')
                ->where(['status'=>0])
                ->order('add_time desc')
                ->field('id,cid,title,tags,price,content,images,video,status,sort,goods_num,shou_num,click_num,com_num,is_free,thoughid,originid,rockid,kindid,weight,size,sku,add_time')
                ->limit($data['page']*$limit,$limit)
                ->select();
        foreach ($info['goods'] as &$goods) {
            $goods['images'] = array_filter(explode(',',$goods['images']));
            $goods['tags'] = array_filter(explode(',',$goods['tags']));
        }
        show_api($info);
    }
    //已闲置商品页
    public function getGoodsUnuse()
    {
        $data = input('post.');
        $limit = 8;
        $info['goods'] = Db::name('shop_goods')
            ->where(['shopstatus'=>1])
            ->order('add_time desc')
            ->field('id,cid,title,tags,price,content,images,video,status,sort,goods_num,shou_num,click_num,com_num,is_free,thoughid,originid,rockid,kindid,weight,size,sku,add_time')
            ->limit($data['page']*$limit,$limit)
            ->select();
        foreach ($info['goods'] as &$goods) {
            $goods['images'] = array_filter(explode(',',$goods['images']));
            $goods['tags'] = array_filter(explode(',',$goods['tags']));
        }
        show_api($info);
    }
    //积分商品数据
    public function integral(){
        $data = input('post.');
        $limit = 8;
        $info['goods'] = Db::name('shop_goods')
            ->where(['shopstatus'=>2])
            ->order('add_time desc')
            ->field('id,cid,title,tags,price,content,images,video,status,sort,goods_num,shou_num,click_num,com_num,is_free,thoughid,originid,rockid,kindid,weight,size,sku,add_time')
            ->limit($data['page']*$limit,$limit)
            ->select();
        foreach ($info['goods'] as &$goods) {
            $goods['images'] = array_filter(explode(',',$goods['images']));
            $goods['tags'] = array_filter(explode(',',$goods['tags']));
        }
//        dump($info);
        show_api($info);
    }
}