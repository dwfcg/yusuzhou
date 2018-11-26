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
 * 签到控制器
 * @package app\forum\thread
 */

class Sign extends Common

{
    //当天签到
    public function signindex()
    {
    	$data = input('post.');
    	$uid = input('post.uid');
//    	$uid = '7';
    	$data['last_time'] = time();
    	$integraldata=Db::name('user_setintegral')->find(1);
//    	dump($integraldata);
    	//点击签到先查表里有没有用户签到过的记录
    	$qian = Db::name('user')->where(['id'=>$uid])->find();
//        dump($qian);
    	//有就判断时间戳,处理签到次数
    	if (time() > $qian['last_time']) {
            $sign_str = date('Y-m-d',$qian['last_time']);//签到时间
            $today_str = date('Y-m-d');//系统时间
            //var_dump($sign_str);
            //var_dump($today_str);
            if ($sign_str == $today_str) {
                show_api($qian,'已经签到了',2);
            }else if($sign_str != $today_str){
                $use = Db::name('user')->where(['id'=>$uid])->update(['last_time'=>$data['last_time']]);
                Db::name('user')->where(['id'=>$uid])->setInc('integral',$integraldata['sign']);
                show_api($use,'签到成功');
            }
    	}
    }
    //签到页面（累计签到）
    public function signedCount(Request $request){
        $user_id = (int)$this->user_data['user_id']; //当前登录者user_id;
        $sign_msg = Db::name('users')->where(['user_id'=>$user_id])->field('pay_points,rignin_time,rignin_count,continue_day,sign_get_points')->find();
        $sign_get_points = $sign_msg['sign_get_points'];
        $sign_msg['sign_get_points'] = explode(',',$sign_get_points);  //字符串 转 数组
        Response::create(['data' =>$sign_msg, 'code' => 2000, 'message' => '获取成功'], 'json')->header($this->header)->send();
    }

//点击领取累计积分
    public function getPoints(Request $request){
        //获取2,3,7,10,15,25
        $user_id = (int)$this->user_data['user_id']; //当前登录者user_id;
        $get_day = $request->param('sign_get_points');  //当被领取时，即时加入数据表
        $sign_day = array(2,3,7,10,15,25);
        $sign_msg = Db::name('users')->where(['user_id'=>$user_id])->field('sign_get_points')->find();
        $get_points = $sign_msg['sign_get_points'];
        if($get_points == 0){
            $sign_get_points = $get_day;
        }else{
            $get_pointsss = explode(',',$get_points);  //转数组
            if(in_array($get_day,$get_pointsss)){
                Response::create(['code' => 2001, 'message' => '已被领取！'], 'json')->header($this->header)->send();
            }
            $sign_get_points = $sign_msg['sign_get_points'].','.$get_day;
        }
        Db::name('users')->where(['user_id'=>$user_id])->update(['sign_get_points'=>$sign_get_points]);
        Response::create(['code' => 2000, 'message' => '领取成功'], 'json')->header($this->header)->send();

    }
//每日签到(送积分)
    public function signed(Request $request){
        $user_id = (int)$this->user_data['user_id']; //当前登录者user_id;
        $result = Db::name('users')->where(['user_id'=>$user_id])->field('continue_day,rignin_time,pay_points,rignin_count')->find();
        $continue_day = $result['continue_day'];  //持续签到天数
        $last_sigin_time = $result['rignin_time'];   //最后签到时间戳
        $pay_points = $result['pay_points'];   //当前登陆者积分数
        $rignin_count = $result['rignin_count'];   //累计签到
        $sigin_time = mktime(0,0,0,date('m'),date('d')+1,date('Y'));  //签到时间（当日凌晨）
        //判断当日是否已签到
        if(time()>$last_sigin_time){
            $time = time() - $last_sigin_time; //时间差
            if ($time > 24*60*60 ) {  // 断签  （第一天）
                Db::name('users')->where(['user_id'=>$user_id])->update(['continue_day'=>1,'rignin_time'=>$sigin_time,'pay_points'=>$pay_points+1,'rignin_count'=>$rignin_count+1]);
            }else if($time < 24*60*60 && $continue_day==1){ //（第二天）
                Db::name('users')->where(['user_id'=>$user_id])->update(['continue_day'=>2,'rignin_time'=>$sigin_time,'pay_points'=>$pay_points+2,'rignin_count'=>$rignin_count+1]);
            }else if($time < 24*60*60 && $continue_day==2){ //（第三天）
                Db::name('users')->where(['user_id'=>$user_id])->update(['continue_day'=>3,'rignin_time'=>$sigin_time,'pay_points'=>$pay_points+4,'rignin_count'=>$rignin_count+1]);
            }else if($time < 24*60*60 && $continue_day==3){ //（第四天）
                Db::name('users')->where(['user_id'=>$user_id])->update(['continue_day'=>4,'rignin_time'=>$sigin_time,'pay_points'=>$pay_points+8,'rignin_count'=>$rignin_count+1]);
            }else if($time < 24*60*60 && $continue_day==4){ //（第五天）
                Db::name('users')->where(['user_id'=>$user_id])->update(['continue_day'=>5,'rignin_time'=>$sigin_time,'pay_points'=>$pay_points+10,'rignin_count'=>$rignin_count+1]);
            }else{     //（第五天以上）
                Db::name('users')->where(['user_id'=>$user_id])->update(['continue_day'=>$continue_day+1,'rignin_time'=>$sigin_time,'pay_points'=>$pay_points+10,'rignin_count'=>$rignin_count+1]); //超过5天 连续加积分5
            }
            Response::create(['code' => 2000, 'message' => '今日签到成功！'], 'json')->header($this->header)->send();
        }else{
            Response::create(['code' => 2000, 'message' => '当日已签到！'], 'json')->header($this->header)->send();
        }
    }

}