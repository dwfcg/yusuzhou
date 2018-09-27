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
* 二级分类
*/
class Category extends Common
{
   //知识
   public function zhishi(){
   	  $id = input('post.sid');
   	  $data = Db::name('forum_cate')->where(['sid'=>$id])->select();
   	  // echo Db::table('forum_category')->getLastSql();
   	  
   }

}