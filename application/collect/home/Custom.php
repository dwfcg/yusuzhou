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

use app\collect\model\Region as RegionModel;

use app\collect\model\Address as AddressModel;

use think\Db;

/**

 * 前台首页控制器

 * @package app\forum\thread

 */

class Custom extends Common
{
    protected function _initialize()
    {
        parent::_initialize();
    }
    //私人订制详情
    public function user_custom()
    {
        $id = input('id');
        $count = Db::name('collect_good')->where('srdz_status',0)->count();
        $goods = Db::name('collect_good')->field('id,cid,title,tags,price,content,images,video,srdz_status,sort,good_num,good_shou,good_click,good_com,is_free,thoughid,originid,rockid,kindid,weight,size,sku,add_time')->find($id);
        $goods['images'] = array_filter(explode(',',$goods['images']));
        // $goods['video'] = array_filter(explode(',',$goods['video']));
        $though = Db::name('shop_though')->alias('a')
                ->join('collect_good c','a.id = c.thoughid')
                ->where(['c.thoughid'=>$goods['thoughid']])
                ->field('a.id,a.name')->find();
        $kind = Db::name('shop_kind')->alias('k')
                ->join('collect_good y','k.id = y.kindid')
                ->where(['y.kindid'=>$goods['kindid']])
                ->field('k.id,k.name')->find();
/*        $theme = Db::name('shop_theme')->alias('t')
                ->join('collect_good e','t.id = e.themeid')
                ->where(['e.themeid'=>$goods['themeid']])
                ->field('t.id,t.name')->find();*/
        $origin = Db::name('shop_origin')->alias('o')
                ->join('collect_good q','o.id = q.originid')
                ->where(['q.originid'=>$goods['originid']])
                ->field('o.id,o.name')->find();
        $rock = Db::name('shop_rock')->alias('r')
                ->join('collect_good s','r.id = s.rockid')
                ->where(['s.rockid'=>$goods['rockid']])
                ->field('r.id,r.name')->find();
/*        $cation = Db::name('shop_cation')->alias('c')
                ->join('collect_good w','c.id = w.cationid')
                ->where(['w.cationid'=>$goods['cationid']])
                ->field('c.id,c.name')->find();*/
        $this->assign('count',$count);
        $this->assign('goods',$goods);
        $this->assign('though',$though);
        $this->assign('kind',$kind);
        // $this->assign('theme',$theme);
        $this->assign('origin',$origin);
        $this->assign('rock',$rock);
        // $this->assign('cation',$cation);
        return $this->fetch();
    }
    //推荐
    public function tuijian()
    {
        $id = input('post.id');
        $goods = Db::name('collect_good')->find($id);
        $data['id'] = array('neq',$id);
        $data['cid'] = $goods['cid'];
        $tui = Db::name('collect_good')->where(['id'=>$data['id'],'cid'=>$data['cid']])
                ->order('add_time desc')
                ->field('id,cid,title,tags,price,content,images,video,srdz_status,sort,good_num,good_shou,good_click,good_com,is_free,thoughid,originid,rockid,kindid,weight,size,sku,add_time')
                ->limit(8)
                ->select();
        // echo Db::table('collect_good')->getLastSql();die;
        foreach( $tui as &$th ){
            $th['images'] = array_filter(explode(',',$th['images']));
            $th['tags'] = array_filter(explode(',',$th['tags']));
        }
        show_api($tui);
    }
    // 商品购买

    public function flow()
    {
        $id = input('id');
        $uid = input('uid');

        if( $id ){
            $goods = Db::name('collect_good')->where('id',$id)->select();    
        }else{
            $goods = Db::name('collect_good')->alias('g')->join('shop_cart c','c.goods_id = g.id')->where('c.uid',$uid)->field('g.*')->select();
        }
        foreach( $goods as &$g ){
            $g['images'] = current(array_filter(explode(',',$g['images'])));    
        }
        $goods_price = array_sum(array_column($goods,'price'));
        $address = AddressModel::where('user_id',$uid)->select();
        $this->assign('first_address',current($address));
        $this->assign('address',$address);
        $this->assign('goods_list',$goods);
        $this->assign('goods_price',$goods_price);
        return $this->fetch();

    }
    //获取省市区
    public function get_region()
    {
        $parent_id = input('parent_id','','intval');
        $region = RegionModel::where('parent_id',$parent_id)->select();
        $this->result($region);
    }
    /*
     * 添加收货地址
     */
    public function add_address()
    {
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
    /*
     * 删除收货地址
     */
    public function del_address()
    {
        $address_id = input('address_id','','intval');
        AddressModel::where( array('address_id'=>$address_id,'user_id'=>$this->user['id']) )->delete();
        $this->result(0,1);
    }
    /*
     * 创建订单
     */
    public function create_order()
    {
        $data = input('post.');
        $address_id = input('address_id');
        $region = AddressModel::where( 'address_id',$address_id )->find();
        if( !$region || !$region['address'] || !$region['sheng'] || !$region['shi'] || !$region['xian']){
            $this->result(0,'address');
        }
        $goods_id = explode(',',$data['goods_id']);
        $goods = Db::name('collect_good')->where('id','in',$goods_id)->select();
        $order['goods_id'] = $data['goods_id'];
        $order['address_id'] = $address_id;
        // $order['user_id'] = $this->user['id'];
        $order['user_id'] = input('post.uid');
        $order['price'] = array_sum(array_column($goods,'price'));
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
        Db::startTrans();
        $orderid = DB::name('collect_order')->insertGetId( $order );
        $update['order_sn'] = time().$orderid;
        DB::name('collect_order')->where( 'id',$orderid )->update($update);
        if( $orderid ){
            Db::commit();
            $this->result($orderid);
        }else{
            Db::rollback();
            $this->result(0,2);
        }
    }

}