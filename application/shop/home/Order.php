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

use app\shop\model\Orders as OrdersModel;

use think\Cookie;

/**

 * 前台首页控制器

 * @package app\cms\admin

 */

class Order extends Common{

    protected function _initialize()

    {

        parent::_initialize();

        $order_status = array('0'=>'待付款','1'=>'待发货','2'=>'待收货','3'=>'待评价','4'=>'已完成','-1'=>'已取消','-3'=>'已删除');

        $this->assign('order_status',$order_status);

    }

    /**
     * 首页
     */
    public function orders($satrt=0,$status = 0) {
       $where['status'] = $status;
       if($status === 0){
           unset($where['status']);
        }
        $where['user_id'] = input('uid');
//        $where['user_id'] = 111;
        // var_dump($where);die;
       // $where['user_id'] = $this->user['id'];
       $orders = OrdersModel::getOrders($where,$satrt,5);    
//       var_dump($status);die;
      // print_r($orders);die;
       $page_count = $orders['count'];
       unset($orders['count']);
       $this->assign('page_count',$page_count);
       $this->assign('status',$status);
       $this->assign('orders',$orders);
       return $this->fetch(); // 渲染模板 
    }

    /**
     * 订单详情
     */
    public function detail($id = '') {       
        $detail = OrdersModel::get_one($id);
//        dump($detail);
        $address = Db::name('address')->find($detail['address_id']);
        $this->assign('address', $address);
        $this->assign('detail', $detail);
        return $this->fetch(); // 渲染模板 
    }
    //新版更新
        public function save(){
            $oid = input('post.oid');
            $status = input('post.status');
            // $oid = '59';
            // $status = '3';
            //取消订单
            if ($status == -1) {
                $res = Db::name('shop_order')->where('id',$oid)->update(['status'=>$status]);
                show_api($res,'已取消');
            }else if ($status == 3) {
                //完成订单
                $res = Db::name('shop_order')->where('id',$oid)->update(['status'=>$status]);
                $data = Db::name('shop_order')->where('id',$oid)->field('id,order_sn,user_id,goods_id,address_id,price,trade_no,pay_type,pay_status,pay_time,express,express_no,status,add_time')->find();
                Db::name('shop_goods')->where(['id'=>$data['goods_id']])->dec('sku')->update(['status'=>0]);
                // dump($as);die;
                show_api($data);
            }else if($status == -3){
                //删除订单
                $res = Db::name('shop_order')->where('id',$oid)->update(['status'=>$status]);
                show_api($res,'已删除');
            }

    }
    //订单评价展示页
    public function goods_comment(){
        $id = input('oid');
        $thread = Db::name('shop_order')->find($id);
        // var_dump($thread);die;
        $this->assign('thread',$thread);
        return $this->fetch();
    }
    //添加评价+-------------------------------------------------------------------
    // public function comment_add(){
    //     $data['uid'] = input('post.uid');
    //     $data['orderid'] = input('post.oid');
    //     $data['sid'] = '8';
    //     $data['images'] = input('post.images');
    //     $data['content'] = input('post.content');
    //     $data['add_time'] = time();
    //     // var_dump($data);die;
    //     $data = Db::name('order_comment')->insertGetId($data);
    //     $result =Db::name('order_comment')->where('id',$data)->select();

    //     show_api($result);
    // }
    // -----------------------------------------------------------------
//      public function comment_add(){
//          $data = input('post.');
//          $data['oid'] = input('post.oid');
//          $data['sid'] = 8;
//          $data['content'] = input('post.content');
//          $data['status'] = 1;
//          // $data['videos'] = '';
//          $data['add_time'] = time();
//          // $data['uid'] = $this->user['id'];
//          $data['user_id'] = input('post.uid');
//          //获取到前端传过来的图片路径
//          $data['images'] = input('post.images');
//          // var_dump($data);die;
//          //  if(!$data['images'] || $data['images'] == ""){
//          //     return "请确认图片是否上传成功";
//          // }
//          // var_dump($data);die;
//          $nam = Db::name('shop_order')->where('id',$data['oid'])->update(['status'=>4]);
//          //新增数据并返回主键值
//          $result = Db::name('forum_thread')->insertGetId($data);
//          show_api($result);
//      }
    public function comment_add(){
        $data = input('post.');
//        dump($data);
        $orderInfo=Db::name('shop_order')->find($data['oid']);
        if(!$orderInfo)
        {
            return show_api('','',0);
        }
        $data['order_id'] = input('post.oid');
        if(!array_key_exists('content',$data))
        {
            return show_api('','',0);
        }
        $data['content'] = input('post.content');
        $data['goods_id']=$orderInfo['goods_id'];
        $data['status'] = 1;
        if(array_key_exists('addto',$data))
        {
            $nam = Db::name('shop_order')->where('id',$data['oid'])->update(['status'=>5]);
            $data['addto'] = 1;
        }
        else{
            $nam = Db::name('shop_order')->where('id',$data['oid'])->update(['status'=>4]);
        }
        $data['add_time'] = time();
        $data['uid'] = input('post.uid');
        //获取到前端传过来的图片路径
        $data['images'] = input('post.images');
        // var_dump($data);die;

        //新增数据并返回主键值
        $result = Db::name('shop_comment')->insertGetId($data);
        $newdata=Db::name('user_setintegral')->select();
        Db::name('user')
            ->where('id',$data['uid'])->setInc('integraal',$newdata[0]['commentgoods']);
//        dump($result);
        show_api($result);
    }

//------------------------------------------之前---------------------------------------------------------
    /**

     * 更新状态

     */

    public function save_status(){
      $oid = input('post.oid');
      $status = input('post.status');
//       var_dump($status);
// var_dump($oid);die;
      if($status && $oid){

        $data['status'] = $status;

        $where['id'] = $oid;

        $result = Db::name('shop_order')->update($data,$where);

        if($result && $status == -1){

          $detial = Db::name('book_order')->find($id);

      	  $stock =  Db::name('books')->where('book_id',$detial['book_id'])->setInc('num');

        }

        $res['status'] = 1;

        echo json_encode($res);exit;

      }

    }
//-----------------------------------------------------------------------------------------
    

     

    /**

     * ajax

     * @param type $satrt

     * @param type $status

     * @return type

     */

    public function ajax_orders($start = 0,$status = '') {

       $order_status =  config('order_status');

       $where['status'] = $status;

       if($status == 0){

           unset($where['status']);

        }

       // $where['user_id'] = $this->user['id'];     
       $where['user_id'] = input('uid');
       $orders = OrdersModel::getOrders($where,$start,10);  

     //  $orders = Db::name('book_order')->where($where)->order('addtime desc')->limit($start,10)->select();

       $page_count = $orders['count'];      

       unset($orders['count']);

       foreach($orders as &$row){

           $row['addtime'] = date('Y-m-d H:i:s', $row['addtime']);

          

		   $row['order_status'] = $order_status[$row['status']];

       }

 

    

       $this->assign('orders',$orders);

       return $this->fetch(); // 渲染模板 

    }

}

