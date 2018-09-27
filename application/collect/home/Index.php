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



namespace app\collect\home;

use think\Db;

/**

 * 前台私人订制控制器

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
     * @author 私人定制轮播图
     * @return mixed
     */

    public function collectInfo()
    {
        $oroderby = 'sort asc';
        $info['slider'] = Db::name('collect_slider')->where('status',1)->order($oroderby)->field('id,title,img,url')->select();
        $info['cates'] = Db::name('collect_category')->where(['status'=>1,'pid'=>['neq',0]])->order($oroderby)->select();
        show_api($info);
    }

    /**
     * 获取分类
     * @author 私人订制
     * @return mixed
     */
    public function collectcate()
    {
        $id = input('id');
        $oroderby = 'sort asc';
        if( $id ){
            $info['child'] = Db::name('collect_category')->where(['status'=>1,'pid'=>$id])->order($oroderby)->select();
        }else{
            $info['first'] = Db::name('collect_category')->where(['status'=>1,'pid'=>0])->order($oroderby)->select();
            $info['child'] = Db::name('collect_category')->where(['status'=>1,'pid'=>$info['first'][0]['id']])->order($oroderby)->select();
        }
        show_api($info);
    }
    //分类列表页
    public function collectList()
    {
        $data = input('post.');
        // $limit = 10;
        // $map['status'] = array('gte',0);
        $map['srdz_status'] = array('gt',0);
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
        $info['goods'] = Db::name('collect_good')->where($map)->order('sort asc')->select();
        foreach( $info['goods'] as &$goods ){
            $goods['images'] = array_filter(explode(',',$goods['images']));
            $goods['tags'] = array_filter(explode(',',$goods['tags']));
        }
        show_api($info);
    }
   //全部
   public function collectquan(){
        $data = input('post.');
        // $limit = 8;
        $info['goods'] = Db::name('collect_good')->order('price asc')->select();
        foreach ($info['goods'] as &$goods) {
           $goods['images'] = array_filter(explode(',',$goods['images']));
           $goods['tags'] = array_filter(explode(',',$goods['tags']));
       }
       show_api($info);
   }
   //可定制
   public function collectke(){
        $data = input('post.');
        // $limit = 8;
        $info['goods'] = Db::name('collect_good')->where('srdz_status',0)
                       ->order('add_time desc')->select();
        foreach ($info['goods'] as &$goods) {
           $goods['images'] = array_filter(explode(',',$goods['images']));
           $goods['tags'] = array_filter(explode(',',$goods['tags']));
       }
       show_api($info);
   }
    //已订制
    public function  collectding(){
        $data = input('post.');
        // $limit = 8;
        //此方法返回一个对象数组，所以要使用数据也必须转换，当然可以直接用对象->limit($data['page']*$limit,$limit)
        $info['goods'] = Db::name('collect_good')->where('srdz_status',1)
                           ->order('add_time desc')->select();
        foreach( $info['goods'] as &$goods ){
            $goods['images'] = array_filter(explode(',',$goods['images']));
            $goods['tags'] = array_filter(explode(',',$goods['tags']));
        }
        show_api($info);
    }

}