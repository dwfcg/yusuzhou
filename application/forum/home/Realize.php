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

 * @package app\index\controller

 */

class Realize extends Common

{
    protected function _initialize()
    {
        parent::_initialize();
    }

    public function index()

    {
        $data = input('post.');
        $data['id'] = array('eq',1);
        $da = Db::name('realize')->where(['id'=>$data['id']])->find();
        $this->assign('da',$da);
        return $this->fetch();

    }

}

