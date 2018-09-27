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

class Realize extends Admin

{

    /**

     * 分类列表

     * @author Lieber

     * @return mixed

     */
    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 数据列表
        $data_list = Db::name('realize')->where($map)->order('add_time asc')->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题']) // 设置搜索框

            ->addColumns([ // 批量添加数据列

                ['id', 'ID'],

                ['name', '名称'],

                ['status','状态', 'status','',['开启', '关闭']],

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

    public function add($id = null)
    {
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            if($data['id']){
                $res = Db::name('realize')->update($data);
            }else{
               $res = Db::name('realize')->insert($data);
            }
            // var_dump($data);die;
            if ($res) {
                $this->success('操作成功', 'index');
            } else {
                $this->error('操作失败');
            }
        }
        
        if($id == null){
          $info = '';
            $title = '添加';
        }else{
            $title = '修改';
           $info = Db::name('realize')->find($id);
        }

        // 显示添加页面

        return ZBuilder::make('form')

            ->addFormItems([

                ['hidden','id'],
                ['text','name','名称'],
                ['ueditor', 'content', '玉蘇周简介'],

                ['radio', 'status', '状态', '', ['开启', '关闭'], 0]

            ])
            ->layout(['status' => 2])
            ->fetch();

    }
    //编辑
    public function edit($id = null){
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if ($gong = Db::name('realize')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功','index');
            }else{
                $this->error('编辑失败');
            }
        }
        $info = Db::name('realize')->find($id);
        return ZBuilder::make('form')
            ->addFormItems([
                    ['hidden','id'],
                    ['text','name','名称'],
                    ['ueditor','content','玉蘇周简介'],
                    ['radio','status', '状态', '', ['开启', '关闭'], 0]
                ])
            ->setFormData($info)
            ->layout(['status' => 2])
            ->fetch();
    }
}