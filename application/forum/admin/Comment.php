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

class Comment extends Admin

{

    /**

     * 版块列表

     * @author Lieber

     * @return mixed

     */

    public function index()

    {

        // 查询

        $map = $this->getMap();
        // 数据列表

        // $section = Db::name('forum_section')->column('id,name');

        $data_list = Db::name('forum_comment')->alias('a')
                             ->join("user b","a.uid=b.id")
                             ->join("forum_thread c","a.tid=c.id")
                             ->join('forum_section d','c.sid=d.id')
                             ->field("a.id,a.content,a.images,a.status,a.add_time,b.name,b.headimg,c.title,d.tionname")
                             ->where($map)->order('add_time desc')->select();
        // $data_list = Db::name('forum_thread')->alias('a')
        //         ->join('forum_comment b','a.id=b.tid')
        //         ->join('user c','b.uid=c.id')
        //         ->join('forum_section d','a.sid=d.id')
        //         ->field('a.title,b.id,b.uid,b.content,b.images,b.status,b.add_time,c.name,c.headimg,d.tionname')
        //         ->where($map)->order('add_time desc')->select();
        // dump($data_list);die;
        foreach ($data_list as $key => $va) {
            $data_list[$key]['content'] = json_decode($va['content']);
        }
        // dump($data_list);exit;
        // $page = $data_list->render();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题','name' => '发帖人'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['title', '帖子标题','link',url('thread/index'), '_blank', 'pop'],
                ['tionname','帖子板块'],
                ['name', '评论人'],
                ['headimg', '评论人头像','img_url'],
                ['content', '评论内容'],
                ['images', '评论图片','img_url'],
                ['status', '评论状态', 'switch'],
                ['add_time','评论时间','datetime'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('add,delete')
            // ->addTopButtons('delete')
            ->addRightButtons([ 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)

            ->fetch(); // 渲染模板

    }

    

    /**

     * 添加

     * @param null $id 广告id

     * @author Lieber

     * @return mixed

     */

    public function add()

    {

        // 保存数据

        if ($this->request->isPost()) {

            // 表单数据

            $data = $this->request->post();

            $data['add_time'] = time();

            if ($result = Db::name('forum_thread')->insert($data)) {

                $this->success('添加成功', 'index');

            } else {

                $this->error('添加失败');

            }

        }

        

        $section = Db::name('forum_section')->column('id,tionname');



        // 显示编辑页面

        return ZBuilder::make('form')

            ->addFormItems([

                ['hidden', 'id'],

                ['select','sid','版块','请选择',$section],

                ['text', 'title', '帖子标题'],

                ['images', 'images', '帖子图片'],

                ['ueditor', 'content', '帖子内容'],

                ['radio', 'status', '帖子状态', '', ['停用', '启用'], 1],

                ['radio', 'is_home', '首页推荐', '', ['停用', '启用'], 1]

            ])

            ->fetch();

    }



    /**

     * 编辑

     * @param null $id 广告id

     * @author Lieber

     * @return mixed

     */

    public function edit($id = null)

    {

        if ($id === null) $this->error('缺少参数');



        // 保存数据

        if ($this->request->isPost()) {

            // 表单数据

            $data = $this->request->post();

            $data['update_time'] = time();

            if ($advert = Db::name('forum_thread')->where('id',$data['id'])->update($data)) {

                $this->success('编辑成功', 'index');

            } else {

                $this->error('编辑失败');

            }

        }



        $info = Db::name('forum_thread')->find($id);

        $section = Db::name('forum_section')->column('id,name');



        // 显示编辑页面

        return ZBuilder::make('form')

            ->addFormItems([

                ['hidden', 'id'],

                ['select','sid','版块','请选择',$section],

                ['text', 'title', '帖子标题'],

                ['images', 'images', '帖子图片'],

                ['ueditor', 'content', '帖子内容'],

                ['radio', 'status', '帖子状态', '', ['停用', '启用'], 1],

                ['radio', 'is_home', '首页推荐', '', ['停用', '启用'], 1]

            ])

            ->setFormData($info)

            ->fetch();

    }

}