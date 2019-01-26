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

use app\shop\model\Region as RegionModel;

use app\shop\model\Address as AddressModel;

use think\Db;
use think\Cache;
use think\Session;

use think\Cookie;
/**

 * 前台首页控制器

 * @package app\forum\thread

 */

class Goods extends Common

{

    protected function _initialize()

    {

        parent::_initialize();

    }

    //商品详情的轮播
    public function lunbo(){
        $id = input('post.id');
        $data =Db::name('shop_goods')->where(['id'=>$id])->field('images,video')->find();
        $data['images'] = array_filter(explode(',',$data['images']));
        if ($data['video'] != '') {
            show_api($data);
        }else if($data['video'] == ''){
            show_api($data,'没有视频',0);
        }
    }
    public function getUrl($id)
    {
        echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?id='.$id;
    }
//---------详情------------------------------------------------------------
    public function index(){
        $id = input('id');
//        $id='1094';
        $uid = input('uid');
//        $uid='111';
        // var_dump($id);
        // var_dump($uid);
        $shou = Db::name('shop_shou')->where(['userid'=>$uid,'goodid'=>$id])->count();
        $count = Db::name('shop_goods')->where('status',1)->count();//在售
        $goods = Db::name('shop_goods')->field('id,cid,title,tags,price,content,images,video,status,sort,goods_num,shou_num,click_num,com_num,is_free,thoughid,originid,rockid,kindid,weight,size,sku,add_time')->find($id);
        $goods['content'] = str_replace("<img "," <img title=\"\" alt=\"\" class=\"lazy\"",$goods['content']);//替换img
        // print_r($goods['content']);die;
        $goods['images'] = array_filter(explode(',',$goods['images']));
        // print_r($goods);die;
        $though = Db::name('shop_though')->alias('a')
                ->join('shop_goods c','a.id = c.thoughid')
                ->where(['c.thoughid'=>$goods['thoughid']])
                ->field('a.id,a.name')->find();
        $kind = Db::name('shop_kind')->alias('k')
                ->join('shop_goods y','k.id = y.kindid')
                ->where(['y.kindid'=>$goods['kindid']])
                ->field('k.id,k.name')->find();
        // $theme = Db::name('shop_theme')->alias('t')
        //         ->join('shop_goods e','t.id = e.themeid')
        //         ->where(['e.themeid'=>$goods['themeid']])
        //         ->field('t.id,t.name')->find();
        $origin = Db::name('shop_origin')->alias('o')
                ->join('shop_goods q','o.id = q.originid')
                ->where(['q.originid'=>$goods['originid']])
                ->field('o.id,o.name')->find();
        $rock = Db::name('shop_rock')->alias('r')
                ->join('shop_goods s','r.id = s.rockid')
                ->where(['s.rockid'=>$goods['rockid']])
                ->field('r.id,r.name')->find();
        // $cation = Db::name('shop_cation')->alias('c')
        //         ->join('shop_goods w','c.id = w.cationid')
        //         ->where(['w.cationid'=>$goods['cationid']])
        //         ->field('c.id,c.name')->find();
        $this->assign('count',$count);
        $this->assign('good',$goods);
        $this->assign('shou',$shou);
        $this->assign('though',$though);
        $this->assign('kind',$kind);
        // $this->assign('theme',$theme);
        $this->assign('origin',$origin);
        $this->assign('rock',$rock);
        // $this->assign('cation',$cation);
//        dump($goods);
        return $this->fetch();
    }
    public function kefu()
    {
        $id = input('id');
        $data = Db::name('shop_goods')->where(['id'=>$id])->field('id,title,price,images')->find($id);
        $data['images'] = array_filter(explode(',',$data['images']));
        show_api($data);
    }
//--------------------------------------------------------------------------------
    //商品分类
    public function fied()
    {
        $data = Db::name('shop_category')->where(['tuijian'=>1])->field('id,name,icon')->select();
        show_api($data);
    }
    //商品推荐
    public function tuijian()
    {
        $id = input('post.id');
        $goods = Db::name('shop_goods')->field('id,cid,title,tags,price,content,images,video,status,sort,goods_num,shou_num,click_num,com_num,is_free,thoughid,originid,rockid,kindid,weight,size,sku,add_time')->find($id);
        // $data['id'] = array('neq',$id);
        $data['cid'] = $goods['cid'];
        $tui = Db::name('shop_goods')->where(['id'=>array('neq',$id),'cid'=>$data['cid']])
                ->order('add_time desc')
                ->field('id,cid,title,tags,price,content,images,video,status,sort,goods_num,shou_num,click_num,com_num,is_free,thoughid,originid,rockid,kindid,weight,size,sku,add_time')
                ->limit(8)
                ->select();
        foreach( $tui as &$th ){
            $th['images'] = array_filter(explode(',',$th['images']));
            $th['tags'] = array_filter(explode(',',$th['tags']));
        }
        show_api($tui);
    }

    //商品收藏
    public function shoucang()
    {
        $user = input('post.userid');
        $good = input('post.goodid');
        $status = input('post.status');
        $time = time();
        $data = ['userid'=>$user,'goodid'=>$good,'status'=>$status];
        $shou = Db::name('shop_shou')->where($data)->select();
        if (!$shou) {
            $sh = Db::name('shop_shou')->insert(['userid'=>$user,'goodid'=>$good,'status'=>$status,'shou_time'=>$time]);
            $ue = Db::name('user')->where(['id'=>$user])->setInc('shoucang');
            $geng = Db::name('shop_goods')->where(['id'=>$good])->setInc('shou_num');
            show_api($geng);
        }else{
            $sc = Db::name('shop_shou')->where(['userid'=>$user,'goodid'=>$good])->find();
            show_api($sc,'已收藏',1);
        }
    }
    //取消收藏
    public function qushou()
    {
        $userid = input('post.userid');
        $goodid = input('post.goodid');
        // $status = input('post.status');
        $data = Db::name('shop_shou')->where(['userid'=>$userid,'goodid'=>$goodid])->delete();
        $ue = Db::name('user')->where(['id'=>$userid])->setDec('shoucang');
        $qushou = Db::name('shop_goods')->where(['id'=>$goodid])->setDec('shou_num');
        if ($data == 0) {
            show_api($data,'已取消',1);
        }else{
            show_api($data,'取消收藏');
        }
    }

    /*

     * 商品评价 没用
     * 2018.05.19

    */
    
    public function pingjia()
    {
        $data = input('post.');
        $data['sid'] = 8;
        $data['status'] = 1;
        $data['videos'] = '';
        $data['add_time'] = time();
        $data['uid'] = $this->user['id'];
        //获取到前端传过来的图片路径
        $data['urlImage'] = input('post.images');
        if(!$data['images'] || $data['images'] == ""){
            return "请确认图片是否上传成功";
        }
        $validate = validate('Thread');
        $check = $validate->check($data);
        if( $check ){
            $info = "评价成功";
            $comment = Db::name('shop_comment')->insertGetId($data);
            $goods = Db::name('shop_goods')->where(['id'=>$data['gid']])->setInc('com_num');
        }else{
            $goods = 0;
            $info = $validate->getError();
        }
        show_api($goods,$info);
        
    }
    //点赞商品评价
    public function dianshop(){
        $goodsid = input('post.gid');
        $userid = input('post.uid');
        $ping = input('post.pingid');
        $status = input('post.status');
        // $time = time();
        $data = ['gid'=>$goodsid,'uid'=>$userid,'pingid'=>$ping,'status'=>$status];
        $dian = Db::name('shop_zan')->insert($data);
        $zan = Db::name('shop_comment')->where(['id'=>$data['id']])->setInc('zan_num');
        show_api($zan);
    }
    //取消点赞商品评价
    public function qushop(){
        $goodsid = input('post.gid');
        $userid = input('post.uid');
        $pingid = input('post.pingid');
        $status = input('post.status');
        $data = ['gid'=>$goodsid,'uid'=>$userid,'pingid'=>$pingid];
        $data = Db::name('shop_zan')->where($data)->find();
        $quzan = Db::name('shop_zan')->where(['id'=>$data['id']])->setField(['status'=>$status]);
        $qu = Db::name('shop_comment')->where(['gid'=>$goodsid,'uid'=>$userid])->setDec('zan_num');
        show_api($qu);

    }
    /*

     * 获取省市列表

     */

    public function get_region(){

        $parent_id = input('parent_id','','intval');
//        dump($parent_id);

        $region = RegionModel::where('parent_id',$parent_id)->select();
//        dump($region);
//        dump(json_encode($region));

        $this->result($region);

    }
    //return  JSon
    public function get_region1(){

        $parent_id = input('parent_id','','intval');
//        dump($parent_id);

        $region = RegionModel::where('parent_id',$parent_id)->select();
//        dump($region);
//        dump(json_encode($region));
        show_api($region);
//        $this->result($region);

    }

    // 商品购买

    public function flow(){
        $id = input('id');
        $uid = input('uid');
        //判断商品是否已经被购买
        // $or = DB::name('shop_order')->where(['goods_id'=>$id])->field('id,order_sn,user_id,goods_id')->count();
        // dump($or);die;
        // if(!empty($or)) $this->result('该商品已被购买');
        if( $id ){
            $goods = Db::name('shop_goods')->where('id',$id)->select();    
        }else{

            $goods = Db::name('shop_goods')->alias('g')->join('shop_cart c','c.goods_id = g.id')->where('c.uid',$uid)->field('g.*')->select();
        }
        foreach( $goods as &$g ){

            $g['images'] = current(array_filter(explode(',',$g['images'])));    
        }
// var_dump($goods);die;
        $goods_price = array_sum(array_column($goods,'price'));
        $address = AddressModel::where('user_id',$uid)->select();
        $this->assign('first_address',current($address));
        $this->assign('address',$address);
        $this->assign('goods_list',$goods);
        $this->assign('goods_price',$goods_price);
        return $this->fetch();
    }

    /*

     * 添加收货地址

     */

    public function add_address(){

        $address_id = input('address_id','','intval');

        // $data['user_id'] = $this->user['id'];
        $data['user_id'] = input('userid','','intval');
        $data['city'] = input('city','','intval');

        $data['mobile'] = input('mobile','','addslashes');

        $data['province'] = input('province','','intval');

        $data['district'] = input('district','','intval');

        $data['address'] = input('address','','addslashes');

        $data['consignee'] = input('user_name','','addslashes');

        $data['zipcode'] = input('postal_code','','intval');

        $data['sheng'] = input('sheng','','addslashes');

        $data['shi'] = input('shi','','addslashes');

        $data['xian'] = input('xian','','addslashes');

        $result = 0;

        if( $address_id ){

            AddressModel::where( 'address_id',$address_id )->update( $data );

        }else{

            $result = AddressModel::insertGetId( $data );

        }

        $this->result(0,$result);

    }
    public function add_addressNew(){

        $address_id = input('address_id','','intval');

        // $data['user_id'] = $this->user['id'];
        $data['user_id'] = input('userid','','intval');
        $data['city'] = input('city','','intval');

        $data['mobile'] = input('mobile','','addslashes');

        $data['province'] = input('province','','intval');

        $data['district'] = input('district','','intval');

        $data['address'] = input('address','','addslashes');

        $data['consignee'] = input('user_name','','addslashes');

        $data['zipcode'] = input('postal_code','','intval');

        $data['sheng'] = input('sheng','','addslashes');

        $data['shi'] = input('shi','','addslashes');

        $data['xian'] = input('xian','','addslashes');

        $result = 0;

        if( $address_id ){

            AddressModel::where( 'address_id',$address_id )->update( $data );

        }else{

            $result = AddressModel::insertGetId( $data );

        }

      show_api($result);

    }
    //设置默认收货地址
    public function isAddress()
    {
        $data=input('post.');
//        dump($data);
        $where=[
            'user_id'=>$data['user_id'],
            'default'=>1,
        ];
        Db::name('address')->where($where)->update(['default'=>0]);
        Db::name('address')->where('address_id',$data['address_id'])->update(['default'=>1]);
        show_api();

    }
    //地址列表
    public function addressData()
    {
        $data=input('post.');
        $rel=Db::name('address')->where('user_id',$data['user_id'])->select();
        show_api($rel);
    }

    /*

     * 删除收货地址

     */

    public function del_address(){

    	$address_id = input('address_id','','intval');

    	AddressModel::where( array('address_id'=>$address_id,'user_id'=>$this->user['id']) )->delete();

        $this->result(0,1);

    }
    public function del_address1(){

        $address_id = input('address_id','','intval');

        AddressModel::where( array('address_id'=>$address_id,'user_id'=>$this->user['id']) )->delete();

        show_api();

    }

   /*
   *   添加购物车
    */
    public function add_cart(){

        $goods_id = input('goods_id');

        $goods = $goods = Db::name('shop_goods')->find($goods_id);

        $is_cart = Db::name('shop_cart')->where(['uid'=>$this->user['id'],'goods_id'=>$goods_id])->find();

        $result = 1;

        if( $goods['status'] != 1 ){

            $result = -1;

        }else if( !$is_cart ){

            $result = Db::name('shop_cart')->insert([

                'uid'=>$this->user['id'],

                'goods_id'=>$goods_id,

                'add_time'=>time()

            ]);

        }

        $this->result(0,$result);

    }
    /**
     *购物车展示数据
     */
    public function cartInfo()
    {
        $cartData=Db::name('shop_cart')->where('uid',$this->user['id'])->select();
        foreach ($cartData as $k =>$v)
        {
//            dump($cartData[$k]['goods_id']);
            $cartData[$k]['goods']=Db::name('shop_goods')->where('id',$cartData[$k]['goods_id'])->select();
//            dump($cartData[$k]['goods'][0]);
            $cartData[$k]['goods'][0]['content'] = str_replace("<img "," <img title=\"\" alt=\"\" class=\"lazy\"",$cartData[$k]['goods'][0]['content']);//替换img
//            // print_r($goods['content']);die;
            $cartData[$k]['goods'][0]['images'] = array_filter(explode(',',$cartData[$k]['goods'][0]['images']));

        }
       return show_api($cartData);
    }
    //判断用户等级
    public function getLevel($uid)
    {
      $info=Db::name('user')->find($uid);
      $ship=Db::name('user_ship')->where('level',$info['level'])->find();
//      dump($ship);die();
      return 0.01*$ship['discount'];
    }

    /*

     * 创建订单

     */

    public function create_order(){

        $data = input('post.');
        //现在order_status为测试字段，等待传入字段
//        $data['order_status']=0;

        $address_id = input('address_id');

        $region = AddressModel::where( 'address_id',$address_id )->find()->toArray();
//        dump($region);
//        if( !$region || !$region['address'] || !$region['sheng'] || !$region['shi'] || !$region['xian']){
        if( !$region){

            show_api('','地址不能为空',0);

        }

        $goods_id = explode(',',$data['goods_id']);
        $order['goods_id'] = $data['goods_id'];
        $order['order_status'] = $data['order_status'];
        $goods = Db::name('shop_goods')->where('id','in',$goods_id)->select();
        $price= array_sum(array_column($goods,'price'));

        //判断订单类型order_status0本店订单存入goods_ID
        //          order_status1闲置订单
        //          order_status2秒杀订单
        if($data['order_status']==0)
        {
            $order['order_status'] = 0;
            //判断是否存在coupon_id，coupon_price有则使用优惠券
            if(array_key_exists('coupon_id',$data))
            {
                $order['coupon_price'] = $data['coupon_price'];
                Db::name('shop_couponlist')
                    ->where('cid',$data['coupon_id'])
                    ->where('uid',$data['uid'])
                    ->update(['status'=>1]);
                $price=$price-$data['coupon_price'];
            }
                //判断是否level
                $discount=$this->getLevel($data['uid']);
            if($discount)
            {
                $price=$discount*$price;
            }


        }
        $order['price'] = $price;
//         dump($goods);die;
        $order['address_id'] = $address_id;

        // $order['user_id'] = $this->user['id'];
        $order['user_id'] = input('post.uid');
    	$order['add_time'] = time();

        $order['address'] = $region['address'];

        $order['consignee'] = $region['consignee'];

        $order['mobile'] = $region['mobile'];

        $order['province'] = $region['province'];

        $order['city'] = $region['city'];

        $order['district'] = $region['district'];

        $order['province_name'] = $region['sheng'];

        $order['city_name'] = $region['shi'];

        $order['district_name'] = $region['xian'];
//        dump($order);die;
        Db::startTrans();
        $orderid = DB::name('shop_order')->insertGetId( $order );

        $update['order_sn'] = time().$orderid;

        DB::name('shop_order')->where( 'id',$orderid )->update($update);
        if( $orderid ){
            Db::commit();
            show_api($orderid,'成功','1');
        }else{
	    	Db::rollback();
            show_api('','失败','0');
	    }
    }
    /**
     * 购物车订单详情页
     * 订单ID
     */
        public function cartOrder()
    {
        $data = input('post.');
        $orderData=Db::name('shop_order')->where('id',$data['orderID'])->find();
        $goods_id = explode(',',$orderData['goods_id']);
        $goods = Db::name('shop_goods')->where('id','in',$goods_id)->select();
        $goods['images'] = array_filter(explode(',',$goods['images']));
        return show_api($goods);

    }

}