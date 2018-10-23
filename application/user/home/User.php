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

namespace app\user\home;

use think\Db;

use think\Session;

use think\Cookie;

/**
 * 前台首页控制器
 * @package app\forum\thread
 */

class User extends Common

{
    // 登录
    public function login(){

        $data = input('post.');
        $time = time();
        $data['sms_code'] = session('sms_code');
        // $data['type'] = 'sms';
        // $data['mobile'] = '18434939742';
        //判断用户登录是用验证码登录还是第三方登录
        if( $data['type'] == 'sms' ){
            $sms_code = Session::get('sms_code');
            // echo $sms_code;
            $user = Db::name('user')->where(['mobile'=>$data['mobile']])->find();
            if( !$user ){
                $user = [
                    'name'=>'手机用户',
                    'sex'=>'1',
                    'yongID'=>rand(111111,999999),
                    'add_time'=>$time,
                    'mobile'=>$data['mobile'],
                    'token'=>md5($time.$data['mobile'].rand(111111,999999))
                ];
                // dump($user);die;
                Db::name('user')->insert($user);
            }
            if( $data['sms_code'] != $sms_code ){
                show_api(null,'验证码不正确',-1);
            }else{
        unset($user['add_time']);
        unset($user['bond']);
        unset($user['bond_price']);
        // unset($user['mobile']);
        // unset($user['openid']);
               Cookie::set('userLogin',json_encode($user),['prefix'=>'']);
             $status0 = Db::name('shop_order')->where(['user_id'=>$user['id'],'status'=>0])->count();//待付
             $statu1 = Db::name('shop_order')->where(['user_id'=>$user['id'],'status'=>1])->count();//待发货
             $stat2 = Db::name('shop_order')->where(['user_id'=>$user['id'],'status'=>2])->count();//待收货
             $sta3 = Db::name('shop_order')->where(['user_id'=>$user['id'],'status'=>3])->count();//待评价
              $user['status0'] = $status0;
              $user['statu1'] = $statu1;
              $user['stat2'] = $stat2;
              $user['sta3'] = $sta3;
                show_api($user,'ok',1);
            }
        //如果用户用微信登录则走wx
        }else if( $data['type'] == 'wx' ){
               $user = Db::name('user')->where('openid',$data['openid'])->find();
                if( !$user ){
                    $user = [
                        'add_time'=>time(),
                        'yongID'=>rand(111111,999999),
                        'sex'=>$data['sex'],
                        'name'=>$data['name'],
                        'openid'=>$data['openid'],
                        'headimg'=>$data['headimg'],
                        'token'=>md5($time.$data['openid'].rand(111111,999999))
                    ];
                    Db::name('user')->insert($user);
                    $userId = Db::name('user')->getLastInsID();
                    $user=Db::name('user')->where('id',$userId)->find();
                    show_api($user,'新用户',1);
                }
               // if($user['status'] != '1') return '您已被禁止登录';
            unset($user['add_time']);
            Cookie::set('userLogin',json_encode($user),['prefix'=>'']);
           $status0 = Db::name('shop_order')->where(['user_id'=>$user['id'],'status'=>0])->count();//待付
           $statu1 = Db::name('shop_order')->where(['user_id'=>$user['id'],'status'=>1])->count();//待发货
           $stat2 = Db::name('shop_order')->where(['user_id'=>$user['id'],'status'=>2])->count();//待收货
           $sta3 = Db::name('shop_order')->where(['user_id'=>$user['id'],'status'=>3])->count();//待评价
            $user['status0'] = $status0;
            $user['statu1'] = $statu1;
            $user['stat2'] = $stat2;
            $user['sta3'] = $sta3;
            show_api($user,'老用户',1); 
        //如果用户使用qq登录则调用qq
        }else if ( $data['type'] == 'qq' ) {
           $user = Db::name('user')->where('openid',$data['openid'])->find();
           if ( !$user ) {
               $user = [
                    'add_time'=>time(),
                    'yongID'=>rand(111111,999999),
                    'sex'=>$data['sex'],
                    'name'=>$data['name'],
                    'openid'=>$data['openid'],
                    'headimg'=>$data['headimg'],
                    'token'=>md5($time.$data['openid'].rand(111111,999999))
               ];
               Db::name('user')->insert($user);
               $userId = Db::name('user')->getLastInsID();
               $user = Db::name('user')->where('id',$userId)->find();
               show_api($user,'新用户','1');
           }
           unset($user['add_time']);
           Cookie::set('userLogin',json_encode($user),['prefix'=>'']);
           $status0 = Db::name('shop_order')->where(['user_id'=>$user['id'],'status'=>0])->count();//待付
           $statu1 = Db::name('shop_order')->where(['user_id'=>$user['id'],'status'=>1])->count();//待发货
           $stat2 = Db::name('shop_order')->where(['user_id'=>$user['id'],'status'=>2])->count();//待收货
           $sta3 = Db::name('shop_order')->where(['user_id'=>$user['id'],'status'=>3])->count();//待评价
            $user['status0'] = $status0;
            $user['statu1'] = $statu1;
            $user['stat2'] = $stat2;
            $user['sta3'] = $sta3;
           show_api($user,'老用户',1);
        //如果用户使用微博登录则走wb
        }else if ( $data['type'] == 'wb' ) {
            $user = Db::name('user')->where('openid',$data['openid'])->find();
            if ( !$user ) {
                $user = [
                    'add_time'=>time(),
                    'yongID'=>rand(111111,999999),
                    'sex'=>$data['sex'],
                    'name'=>$data['name'],
                    'openid'=>$data['openid'],
                    'headimg'=>$data['headimg'],
                    'token'=>md5($time.$data['openid'].rand(111111,999999))
                ];
                Db::name('user')->insert($user);
                $userId = Db::name('user')->getLastInsID();
                $user = Db::name('user')->where('id',$userId)->find();
                show_api($user,'新用户',1);
            }
            unset($user['add_time']);
            Cookie::set('userLogin',json_encode($user),['prefix'=>'']);
           $status0 = Db::name('shop_order')->where(['user_id'=>$user['id'],'status'=>0])->count();//待付
           $statu1 = Db::name('shop_order')->where(['user_id'=>$user['id'],'status'=>1])->count();//待发货
           $stat2 = Db::name('shop_order')->where(['user_id'=>$user['id'],'status'=>2])->count();//待收货
           $sta3 = Db::name('shop_order')->where(['user_id'=>$user['id'],'status'=>3])->count();//待评价
            $user['status0'] = $status0;
            $user['statu1'] = $statu1;
            $user['stat2'] = $stat2;
            $user['sta3'] = $sta3;
            show_api($user,'老用户',1);
        }

    }
    //微信 QQ 微博登录必须绑定手机号
    public function bind_mobile(){
    	$data = input('post.');
        $time = time();
        //判断手机号是否为空
        if( !$data['mobile'] ){
            show_api('','请输入手机号码',0);
        }
        //判断获取到的验证码是否正确
        if( $data['sms_code'] != $sms_code ){
            show_api(null,'验证码不正确',-1);
        }
        //取值
        $sms_code = Session::get('sms_code');
        //查询手机号
        $user = Db::name('user')->where('mobile',$data['mobile'])->find();
        //判断手机号是否为空
            if(!$user){
                Db::name('user')->where('id',$data['id'])->update(['mobile'=>$data['mobile']]);
                show_api('','绑定成功',1);
            }
        //判断用户openid是否唯一
        if($user['openid']){
            show_api('','你输入手机号已绑定其他账号',0);
          }
            $user_data= Db::name('user')->where('id',$data['id'])->find();
            $update['sex']=$user_data['sex'];
            $update['name']=$user_data['name'];
            $update['openid']=$user_data['openid'];
            $update['headimg']=$user_data['headimg'];
            $update['token']=$user_data['headimg'];
            $res=Db::name('user')->where('id',$data['id'])->delete();
            if($res){
                Db::name('user')->where('id',$user['id'])->update($update);
                show_api('','绑定成功',1);
            }
    }

    // 发送验证码
    public function postsms(){
        $data = input('post.');
        // $data['mobile'] = '18434939742';
        if( !$data['mobile'] ){
            show_api('','请输入手机号码',0);
        }
        $user = Db::name('user')->where('mobile',$data['mobile'])->find();
        // $sms_code =rand(111111,999999);
        $sms_code = '123123';
        if(!$user){
            $result = plugin_action('DySms/DySms/send', [$data['mobile'], ['code' => $sms_code], '用户注册验证码']);
        }else{
           $result = plugin_action('DySms/DySms/send', [$data['mobile'], ['code' => $sms_code], '用户登录']);
        }
        if($result['code']){
                show_api('','发送失败，错误代码：'. $result['code']. ' 错误信息：'. $result['msg'],-1);
        } else {
                Session::set('sms_code',$sms_code);
                // session('sms_code',$sms_code);
                show_api($sms_code,'发送成功',1);
          }

    }

//----------------------------------------------------------------------------------------------
   //获取用户信息
   public function getUserInfo(){
       $uid = input('uid');
       // $uid = '50';
       $token = input('token');
       if ($uid) {
           $user = Db::name('user')->where('id',$uid)->find();
           $status0 = Db::name('shop_order')->where(['user_id'=>$uid,'status'=>0])->count();//待付
           $statu1 = Db::name('shop_order')->where(['user_id'=>$uid,'status'=>1])->count();//待发货
           $stat2 = Db::name('shop_order')->where(['user_id'=>$uid,'status'=>2])->count();//待收货
           $sta3 = Db::name('shop_order')->where(['user_id'=>$uid,'status'=>3])->count();//待评价
           $user['status0'] = $status0;
           $user['statu1'] = $statu1;
           $user['stat2'] = $stat2;
           $user['sta3'] = $sta3;
        }else{
            $user = Db::name('user')->where('token',$token)->find();
        }
       show_api($user,$user?'获取成功':'获取失败',$user?1:-1);

   }
//--------------------------------------------------------------------------------------------
    //查询当前用户是否关注该用户
    public function chaguan(){
        $id = input('post.uid');
        $dangid = input('post.dangid');
        $data = Db::name('user_guan')->alias('a')
              ->join('user b','a.threadid=b.id')
              ->where(['dangid'=>$dangid,'threadid'=>$id])
              ->field('a.status as astatus,b.name,b.headimg,b.guanzhu,b.fensi,b.shoucang,b.fabu,b.huozan')
              ->find();
        if (!$data) {
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }
        show_api($data);
    }
//------------------------------------------------------------
    public function wdsc(){
        $uid = input('uid');
        // $uid = '59';
        $shou = Db::name('shop_shou')->alias('s')
            ->join('shop_goods g','s.goodid=g.id')
            ->where(['userid'=>$uid])
            ->field('s.goodid,g.id,g.images,g.title,g.shou_num,g.price')
            ->select();
        foreach ($shou as $key => $v) {
            $shou[$key]['images'] = substr($v['images'],0,strpos($v['images'],','));
        }
        show_api($shou);
    }

     //修改信息
    public function save_info(){
        $uid = input('uid');
        $token = input('token');
        $data = input('post.');
        if(isset($data['password'])){
            $data['password'] = md5($data['password']);    
        }
        if( $uid ){
            $user = Db::name('user')->where('id',$uid)->update($data);
        }else{
            $user = Db::name('user')->where('token',$token)->update($data);
        }
        show_api($user,'修改成功',1);
    }
    //注销
    public function logout(){
        Cookie::clear('userLogin');
        show_api(1,'注销成功',1);
    }
//--------------------客服-----------------------------------------------------
    //获取用户
    public function huo()
    {
        $id = input('post.id');
        // $id = '50';
        $da = Db::name('user')->where(['id'=>$id])->field('id,sex,name,openid,headimg,mobile,email,guanzhu,fensi,zan,shoucang,fabu,huozan,token,status')
           ->find();

        show_api($da);
    }
    //好友列表
    public function hao()
    {
       $data = Db::name('user')->alias('u')
               // ->join('user u','s.yongid=u.id')
               ->where(['id'=>array('neq',7)])
               ->field('u.id,u.sex,u.name,u.openid,u.headimg,u.mobile,u.email,u.guanzhu,u.fensi,u.zan,u.shoucang,u.fabu,u.huozan,u.token,u.add_time,u.status')
               ->select();
       show_api($data);
    }
//    申请闲置

    /**
     * user_id
     * images
     * name
     * price
     *commont
     */
    public function applyUnuse()
    {
        $data=input('post.');
        if(Db::name('shop_unuse')->insert($data))
        {
            show_api();
        }else
        {
            show_api('','','0');
        }
    }
    /**
     **用户闲置商品快递
     * user_id
     * express
     * express_no
     */
    public function getExpress()
    {
        $data=input('post.');
        $update=[
            'express'=>$data['express'],
            'express_no'=>$data['express_no'],
            'status'=>3
        ];
        $where['user_id']=$data['user_id'];
//        $where=['user_id'=>$data['user_id']];
        $userdata=Db::name('shop_unuse')->where($where)->find();
        if(!$userdata)
        {
            show_api('','',0);
        }
        Db::name('shop_unuse')->where($where)->update($update);
        show_api();
    }
    /**
     * 快递信息表
     */
    public function express(){
        $address=Db::name('order_delivery')->select();
//        dump($address);
        $data=[];
        foreach ($address as $k => $v)
        {
            $data[$address[$k]['id']]=$address[$k]['name'];
        }
//        dump($data);
        return show_api($data);
    }

    /**
     * 获取全部用户闲置商品信息
     */
    public function getUnuse()
    {
        $data=input('post.');
        $info['goods']=Db::name('shop_unuse')->where('user_id',$data['user_id'])->select();
        foreach ($info['goods'] as &$goods) {
            $goods['images'] = array_filter(explode(',',$goods['images']));
        }
        return show_api($info);
    }
    /**
     * 取消申请
     * 闲置商品ID
     * 用户user_ID
     */
    public  function del(){
        $data=input('post.');
        $where=[
            'user_id'=>$data['user_id'],
            'id'=>$data['id']
        ];
        $unuseData=Db::name('shop_unuse')->where($where)->find();
        if($unuseData['status']==0)
        {
            $unuseData=Db::name('shop_unuse')->where($where)->delete();
            show_api();
        }
        show_api('','不能取消',0);

    }
    /**
     * 获取用户单个闲置商品信息
     * 闲置ID
     */
    public  function getUnusedata(){
        $data=input('post.');
        $where=[
            'id'=>$data['id']
        ];
        $goods=Db::name('shop_unuse')->where($where)->find();
        $goods['images'] = array_filter(explode(',',$goods['images']));
        return show_api($goods);
    }
}