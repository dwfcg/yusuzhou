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
/**

 * 前台首页控制器

 * @package app\forum\thread

 */
class Video extends Common
{
	//宣传视频
	public function index(){
        $data = Db::name('forum_face')->where(['id'=>1,'status'=>1])->find();
        if ($data['zhanshi']=='1') {
        	show_api($data);
        }else if($data['zhanshi']=='0'){
        	 show_api($data,'已关闭',0);
           }
	}
        //首页
    public function sysp(){
        $data = Db::name('forum_face')->where(['id'=>2,'status'=>1])->find();
        if ($data['zhanshi']=='1') {
                show_api($data);
        }else if($data['zhanshi']=='0'){
                 show_api($data,'已关闭',0);
           }
    }
        //直播
    public function zbsp(){
        $data = Db::name('forum_face')->where(['id'=>4,'status'=>1])->find();
        if ($data['zhanshi']=='1') {
                show_api($data);
        }else if($data['zhanshi']=='0'){
                 show_api($data,'已关闭',0);
           }
    }
    //消息下面的广告图
    public function advices(){
        $data['advices'] = Db::name('forum_advices')->where(['status'=>1,'guan'=>1])->select();
        show_api($data);
 
    }
}