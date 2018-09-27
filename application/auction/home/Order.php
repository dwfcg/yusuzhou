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

namespace app\auction\home;

use app\index\controller\Home;

use think\Db;

use think\Cookie;
/**
 * paimai控制器
 * @package app\forum\thread
 */
class Order extends Home
{
    /**
     * 首页
     * @author Zain
     */
    public function index()
    {
        $status = input('status') ? input('status') : 0;
        $user = json_decode(Cookie::get('userLogin',''),true);
        $page = 0;
        $user['id'] = 1;
        if($user){
            $where['o.status'] = $status;
            $where['o.uid'] = $user['id'];
            $orders = Db::name('auction_order')
                      ->alias('o')
                      ->field('o.*,g.title,g.imgs')
                      ->join('ysz_auction_goods g',' o.gid = g.id','left')
                      ->where($where)
                      ->limit(0,10)
                      ->order('o.id desc')
                      ->select();
            foreach($orders as &$v){
                if($v['imgs']){
                    $imgs = explode(",",$v['imgs']);
                }
                $v['pic'] = $imgs[0];
            }
            $wherec['status'] = $status;
            $wherec['uid'] = $user['id'];
            $count = Db::name('auction_order')->where($wherec)->count();
            $page = max(1, ceil($count / 10));
            $this->assign('orders',$orders);
        }
        $order_status = array('-1'=>'竞拍失败','0'=>'竞拍中','1'=>'竞拍成功');
        $this->assign('order_status',$order_status);
        $this->assign('status',$status);
        $this->assign('page',$page);
        return $this->fetch();
    }
    /**
     * ajax
     * @param type $satrt
     * @param type $status
     * @return type
     */
    public function ajax_orders($start = 0,$status = '')
    {
        $order_status =  config('order_status');
        $status = input('status') ? input('status') : 0;
        $user = json_decode(Cookie::get('userLogin',''),true);
        $page = 0;
        $user['id'] = 1;
        if($user){
            $where['o.status'] = $status;
            $where['o.uid'] = $user['id'];
            $orders = Db::name('auction_order')
                      ->alias('o')
                      ->field('o.*,g.title,g.imgs')
                      ->join('ysz_auction_goods g',' o.gid = g.id','left')
                      ->where($where)
                      ->limit($status,10)
                      ->order('o.id desc')
                      ->select();
            foreach($orders as &$v){
                if($v['imgs']){
                    $imgs = explode(",",$v['imgs']);
                }
                $v['pic'] = $imgs[0];
            }
            $wherec['status'] = $status;
            $wherec['uid'] = $user['id'];
            $count = Db::name('auction_order')->where($wherec)->count();
            $page = max(1, ceil($count / 10));
            $this->assign('orders',$orders);
        }
       $order_status = array('-1'=>'竞拍失败','0'=>'竞拍中','1'=>'竞拍成功');
       $this->assign('order_status',$order_status);
       $this->assign('status',$status);
       return $this->fetch(); // 渲染模板 
    }
    public function detail()
    {
      Db::startTrans();
	    $orderid = DB::name('shop_order')->insertGetId( $order );
      $update['order_sn'] = time().$orderid;
      DB::name('shop_order')->where( 'id',$orderid )->update($update);
	    if( $orderid ){
	    	Db::commit();
	    	$this->result($order);
	    }else{
	    	Db::rollback();
	    	$this->result(2);
	    }
        return $this->fetch('pay');
    }

}