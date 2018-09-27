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

namespace app\forum\admin;

use think\Db;

use app\admin\controller\Admin;

use app\common\builder\ZBuilder;

/**

 * 版块控制器

 * @package app\cms\admin

 */

class Guan extends Admin

{
    public function guan()
    {
        $map = $this->getMap();
        // dump($map);exit;
        $map['uid'] = '7';
        // 数据列表
        $data_list = Db::name('forum_thread')->alias('a')
                                             ->join("user b","a.uid=b.id")
                                             ->join('forum_category s','a.cid=s.id')
                                             ->field("a.*,b.name,b.headimg,s.name as sname")
                                             ->where($map)->order('add_time desc')->paginate();
        // echo Db::table('forum_thread')->getLastSql();die;
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题','name' => '发帖人']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['title', '帖子标题','link',url('edit',['id'=>'__id__'])],
                ['sname','帖子分类'],
                ['name', '发帖人'],
                ['headimg', '发帖人头像','img_url'],
                ['view_num', '浏览人数', 'text.edit'],
                ['zan_num', '点赞次数', 'text.edit'],
                ['status', '帖子状态', 'status','',['关闭','开启']],
                ['is_home', '首页推荐', 'status','',['否','是']],
                ['add_time','发帖时间','datetime'],
                ['right_button', '操作', 'btn']

            ])
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
}
?>