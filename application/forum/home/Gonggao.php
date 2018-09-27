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



namespace app\forum\home;

use think\Db;

use think\Cookie;

use QiNiu\Auth;
/**

 * 前台首页控制器

 * @package app\forum\thread

 */

class Gonggao extends Common

{
	//公告
	public function index(){
        $data = Db::name('home_notice')->where(['id'=>1,'status'=>0])->find();
        if($data['gongzhan'] == '1'){
        	show_api($data);
        }else if($data['gongzhan'] == '0'){
        	show_api($data,'已关闭',0);
        }
        
	}
}