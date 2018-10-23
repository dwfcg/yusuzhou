<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/9
 * Time: 13:13
 */

namespace app\user\home;


use app\user\model\ShopCoupon;
use app\user\model\ShopCouponlist;
use think\Db;

class Coupon    extends Common
{
    /**
     * 获取用户的优惠券
     * @uid 用户ID
     */
    public function getUserCoupon()
    {
        $data=input('post.');
        if($data[''])
        $info = Db::name('shop_couponlist')->alias('a')
            ->join('user b','a.uid=b.id')
            ->join('shop_order c','a.order_id=c.id')
            ->join('shop_coupon d','a.cid=d.id')
            ->field('a.id,d.name as couponname,a.use_time,a.status,a.type,b.name,c.order_sn')
            ->where('a.uid',$data['uid'])
            ->select();
        if(!$info)
        {
            $info = Db::name('shop_couponlist')->alias('a')
                ->join('user b','a.uid=b.id')
                ->join('shop_coupon d','a.cid=d.id')
                ->field('a.id,d.name as couponname,a.use_time,a.status,a.type,b.name')
                ->where('a.uid',$data['uid'])
                ->select();
        }
//        dump($info);
        show_api($info);
    }

    /**
     * 注册送优惠券
     * @uid用户ID
     */
    public function loginCoupon(){
        $data=input('post.');
        $coupon_info = Db::name('shop_coupon')->where(array('type' => 0, 'status' => 1))->select();
        foreach ($coupon_info as $k => $v)
        {
            if($coupon_info['send_num'] >= $coupon_info['createnum'] && $coupon_info['createnum'] != 0){

            }else{
                if($v['send_end_time'] >time()){
                    $data = array('uid' => $data['uid'], 'cid' => $v['id'], 'type' => 0, 'send_time' => time(),'status'=>0);
                    Db::name('shop_couponlist')->insert($data);
                    Db::name('shop_coupon')->where(array('id' => $v['id'], 'status' => 1))->setInc('send_num');
                }
            }

        }
        show_api();



    }
    /**
     * 领券
     * @param $id 优惠券id
     * @param $user_id
     */
    public function getCoupon()
    {
        $data=input('post.');
        $return= $this->get_coupon($data['id'],$data['user_id']);
       return json($return);
    }
    public function get_coupon($id, $user_id)
    {
        if (empty($id)){
            $return = ['status' => 0, 'msg' => '参数错误'];
        }
        if ($user_id) {
            $coupon_info = Db::name('shop_coupon')->where(array('id' => $id, 'status' => 1))->find();
            if (empty($coupon_info)) {
                $return = ['status' => 0, 'msg' => '活动已结束或不存在，看下其他活动吧~'];
            } elseif ($coupon_info['send_end_time'] < time()) {
                //来晚了，过了领取时间
                $return = ['status' => 0, 'msg' => '抱歉，已经过了领取时间'];
            } elseif ($coupon_info['send_num'] >= $coupon_info['createnum'] && $coupon_info['createnum'] != 0) {
                //来晚了，优惠券被抢完了
                $return = ['status' => 0, 'msg' => '来晚了，优惠券被抢完了'];
            } else {
                if (Db::name('shop_couponlist')->where(array('cid' => $id, 'uid' => $user_id))->find()) {
                    //已经领取过
                    $return = ['status' => 2, 'msg' => '您已领取过该优惠券'];
                } else {
                    $data = array('uid' => $user_id, 'cid' => $id, 'type' => 2, 'send_time' => time(),'status'=>0);
                    Db::name('shop_couponlist')->insert($data);
                    Db::name('shop_coupon')->where(array('id' => $id, 'status' => 1))->setInc('send_num');
                    $return = ['status' => 1, 'msg' => '恭喜您，抢到' . $coupon_info['money'] . '元优惠券!'];
                }
            }
        } else {
            $return = ['status' => 0, 'msg' => '请先登录'];
        }

        return $return;
    }
    public function get_arr_column($arr, $key_name)
    {
        $arr2 = array();
        foreach($arr as $key => $val){
            $arr2[] = $val[$key_name];
        }
        return $arr2;
    }
    /**
     * 获取用户可用的优惠券
     * UID用户ID
     */
    public function getUserAble()
    {
        $data=input('post.');
//        dump($data);
        $re=$this->getUserAbleCouponList($data['uid']);
        $data=[];
        foreach ($re as $k => $v)
        {
            $data[$k]=$re[$k]->toArray();
        }
        show_api($data);
    }

    /**
     *  获取商品优惠券
     * @cartList商品总价格
     * @UID 用户id
     */
    public  function getCartCoupon()
    {
        $data=input('post.');
        $userCouponList=$this->getUserAbleCouponList($data['uid']);
        $coupondata=$this->getCouponCartList($data['cartList'],$userCouponList);
        show_api($coupondata);

    }
    /**
     * 转换购物车的优惠券数据
     * @param $cartList |购物车商品总价信息
     * @param $userCouponList |用户优惠券列表
     * @return mixedable
     */
    public function getCouponCartList($cartList, $userCouponList)
    {
        $userCouponArray = collection($userCouponList)->toArray();  //用户的优惠券
        $couponNewList = [];
//        $coupon_num = 0;
        foreach ($userCouponArray as $couponKey => $couponItem) {
            if ($userCouponArray[$couponKey]['coupon']['use_type'] == 0) { //全店使用优惠券
                if ($cartList >= $userCouponArray[$couponKey]['coupon']['condition']) {  //订单商品总价是否符合优惠券购买价格
                    $userCouponArray[$couponKey]['coupon']['able'] = 1;
//                    $coupon_num += 1;
                } else {
                    $userCouponArray[$couponKey]['coupon']['able'] = 0;
                }
            }
            $couponNewList[] = $userCouponArray[$couponKey];
        }
//        $this->userCouponNumArr['usable_num'] = $coupon_num;
        return $couponNewList;
    }
    /**
     * 获取用户可用的优惠券
     * @param $user_id|用户id
     * @param array $goods_ids|限定商品ID数组
     * @param array $goods_cat_id||限定商品分类ID数组
     * @return array
     */
    public function getUserAbleCouponList($user_id, $goods_ids = array(), $goods_cat_id = array())
    {
        $CouponList = new ShopCouponlist();
        $Coupon = new ShopCoupon();
        $userCouponArr = [];
        $userCouponList = $CouponList->where('uid', $user_id)->where('status', 0)->select();//用户优惠券
        if(!$userCouponList){
            return $userCouponArr;
        }
        $userCouponId = $this->get_arr_column($userCouponList, 'cid');
        $couponList = $Coupon->with('GoodsCoupon')
            ->where('id', 'IN', $userCouponId)
            ->where('status', 1)
            ->where('use_start_time', '<', time())
            ->where('use_end_time', '>', time())
            ->select();//检查优惠券是否可以用
        foreach ($userCouponList as $userCoupon => $userCouponItem) {
            foreach ($couponList as $coupon => $couponItem) {
                if ($userCouponItem['cid'] == $couponItem['id']) {
                    //全店通用
                    if ($couponItem['use_type'] == 0) {
                        $tmp = $userCouponItem;
                        $tmp['coupon'] = $couponItem->append(['use_type_title'])->toArray();
                        $userCouponArr[] = $tmp;
                    }
                    //限定商品
                    if ($couponItem['use_type'] == 1 && !empty($couponItem['goods_coupon'])) {
                        foreach ($couponItem['goods_coupon'] as $goodsCoupon => $goodsCouponItem) {
                            if (in_array($goodsCouponItem['goods_id'], $goods_ids)) {
                                $tmp = $userCouponItem;
                                $tmp['coupon'] = array_merge($couponItem->append(['use_type_title'])->toArray(), $goodsCouponItem->toArray());
                                $userCouponArr[] = $tmp;
                                break;
                            }
                        }
                    }
                    //限定商品类型
                    if ($couponItem['use_type'] == 2 && !empty($couponItem['goods_coupon'])) {
                        foreach ($couponItem['goods_coupon'] as $goodsCoupon => $goodsCouponItem) {
                            if (in_array($goodsCouponItem['goods_category_id'], $goods_cat_id)) {
                                $tmp = $userCouponItem;
                                $tmp['coupon'] = array_merge($couponItem->append(['use_type_title'])->toArray(), $goodsCouponItem->toArray());
                                $userCouponArr[] = $tmp;
                                break;
                            }
                        }
                    }
                }
            }
        }
        return $userCouponArr;
    }

}