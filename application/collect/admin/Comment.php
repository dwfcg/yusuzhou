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



namespace app\collect\admin;

use think\Db;

use app\admin\controller\Admin;

use app\common\builder\ZBuilder;

/**

 * 评论控制器

 * @package app\cms\admin

 */

class Comment extends Admin

{
	public function index(){
		$map = $this->getMap();
        $data_list = Db::name('collect_comment')->alias('a')

                             ->join("user b","a.uid=b.id")

                             ->join("collect_good c","a.gid=c.id")

                             ->field("a.*,b.name,b.headimg,c.title")

                             ->where($map)->order('add_time desc')->paginate();
        return ZBuilder::make('table')
            ->setSearch(['title'=>'标题'])
            ->addColumns([
                    ['id','ID'],
                    ['title','商品标题'],
                    ['name','评论人'],
                    ['headimg','评论人头像','img_url'],
                    ['content','评论内容','text.edit'],
                    ['images','评论图片','pictures'],
                    ['status','评论状态','switch'],
                    ['right_button','操作','btn']
            	])
            ->addTopButtons('delete')
            ->addRightButtons(['delete'=>['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch();
	}
}
