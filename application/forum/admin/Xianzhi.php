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
 * 分类控制器
 * @package app\cms\admin
 */
class Xianzhi extends Admin
{
    /**
     * 闲置分类列表
     * @author Lieber
     * @return mixed
     */
    public function index()
    {
        // 查询
        $map = $this->getMap();
        $map['sid'] = '9';
        // 数据列表
        // $data_list = Db::name('forum_cate')->where($map)->order('sort asc')->paginate();
        $data_list = Db::name('forum_cate')->alias('a')
                    ->join('forum_section s','a.sid = s.id')
                    ->field('a.*,s.tionname')
                    ->where($map)
                    ->order('sort asc')
                    ->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['name' => '分类名称']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['name', '分类名称','link',url('edit',['id'=>'__id__'])],
                ['tionname','所属板块'],
                ['sort', '分类排序', 'text.edit'],
                ['status', '分类状态', 'status','',['关闭','开启']],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    /**
     * 新增
     * @author Lieber
     * @return mixed
     */
    public function add()
    {
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            $data['update_time'] = time();
            if ($advert = Db::name('forum_cate')->insert($data)) {
                $this->success('新增成功', 'index');
            } else {
                $this->error('新增失败');
            }
        }

        $section = Db::name('forum_section')->order('sort asc')->column('id,tionname');

        // 显示添加页面

        return ZBuilder::make('form')

            ->addFormItems([

                ['select', 'sid', '所属板块','', $section],

                ['text', 'name', '分类名称', '<span class="text-danger">必填</span>'],

                ['number', 'sort', '分类排序','','从小到大的排序'],

                ['radio', 'status', '分类状态', '', ['停用', '启用'], 1]

            ])
            ->layout(['sid' => 6, 'name' => 6, 'sort' => 2, 'status' => 4])
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

            if ($advert = Db::name('forum_cate')->where('id',$data['id'])->update($data)) {

                $this->success('编辑成功', 'index');

            } else {

                $this->error('编辑失败');

            }

        }



        $info = Db::name('forum_cate')->find($id);

        $section = Db::name('forum_section')->order('sort asc')->column('id,tionname');

        // 显示编辑页面

        return ZBuilder::make('form')

            ->addFormItems([

                ['hidden', 'id'],

                ['select', 'sid', '所属板块','', $section],

                ['text', 'name', '分类名称', '<span class="text-danger">必填</span>'],

                ['number', 'sort', '分类排序','','从小到大的排序'],

                ['radio', 'status', '分类状态', '', ['停用', '启用'], 1]

            ])

            ->setFormData($info)
            ->layout(['sid' => 6, 'name' => 6, 'sort' => 2, 'status' => 4])
            ->fetch();

    }

}