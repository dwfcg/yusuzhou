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

use think\Db;
use app\collect\home\Tree;
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

//--------------------------------------------------------------------------------
    //私人定制分类
    public function fied(){
        $data = Db::name('collect_category')->where(['tuijian'=>1])->field('id,name,icon')->select();
        show_api($data);
    }

    //私人定制申请
    public function shen()
    {
        $data['content'] = input('post.content');
        $data['price_yu'] = input('post.price_yu');
        $data['uid'] = input('post.uid');
        $data['username'] = input('post.username');
        $data['phone'] = input('post.phone');
        $data['province'] = input('post.province');
        $data['address'] = input('post.address');
        $data['beizhu'] = input('post.beizhu');
        $data['images'] = input('post.images');
        $data['status'] = 0;
        $data['add_time']=time();
        $qing = Db::name('collect_apply')->insert($data);
        show_api($qing);
    }
    //状态
    public function zhuang()
    {
        $uid = input('uid');
        $data = Db::name('collect_apply')->where('uid',$uid)->count();
        $status = Db::name('collect_apply')->where('uid',$uid)->sum('status');
        if ($data == $status) {
            show_api('','可以申请定制');
        }else{
            show_api('','已申请定制',0);
        }
    }
}