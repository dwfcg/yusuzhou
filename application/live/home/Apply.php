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



namespace app\live\home;

use app\index\controller\Home;

use think\Db;

use think\Cookie;

/**

 * 申请直播控制器

 * 

 */
class Apply extends Home
{
	//申请直播
	public function index()
	{
		$user = json_decode(Cookie::get('userLogin',''),true);
		$data['uid'] = input('post.uid');
                $data['name'] = input('post.name');
                $data['phone'] = input('post.phone');
                $data['title'] = input('post.title');

                $data['applytime'] = input('post.applytime');
                $data['starttime'] = input('post.starttime');
                $data['endtime'] = input('post.endtime');
                $data['add_time'] = time();
		$data = Db::name('live_apply')->insertGetId($data);
        //申请成功给前台返回状态0
        $result = Db::name('live_apply')->where('id',$data)->find();
        // foreach ($result as &$th) {
        //     $th['addtime'] = date('Y-m-d H:i:s',$th['addtime']);
        // }
		show_api($result);
	}
}