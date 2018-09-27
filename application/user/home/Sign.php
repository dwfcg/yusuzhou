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
    	$uid = '7';
    	$data['last_time'] = time();
    	//点击签到先查表里有没有用户签到过的记录
    	$qian = Db::name('user')->where(['id'=>$uid])->find();
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
                Db::name('user')->where(['id'=>$uid])->setInc('integral',5);
                show_api($use,'签到成功');
            }
    	}
    }
}