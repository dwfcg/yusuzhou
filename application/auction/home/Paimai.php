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

namespace app\auction\home;

use app\index\controller\Home;

use think\Db;

use think\Cookie;
/**
 * 拍卖首页控制器
 * @package app\forum\thread
 */
class Paimai extends Home
{
	//我的拍卖
	public function user()
	{
		$data = input('post.');
		$uid = input('post.uid');$uid=45;
		$cha = Db::name('auction_record')->where(['userid'=>$uid])->field('id,goodid')->select();
		foreach ($cha as $key => $va) {
			$da = Db::name('auction_goods')->where(['id'=>$va['goodid']])->field('id,title,tags,imgs,start_price,price,price_range,content,start_time,end_time,partake,status,offer,bands')
		      ->select();
			foreach($da as $key => &$v){
				$da[$key]['imgs']=explode(',',$v['imgs']);
			}		    
		}
		show_api($da);
	}
	
}