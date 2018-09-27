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

class Gonggao extends Admin

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
        $data_list = Db::name('home_notice')->where($map)->order('retime asc')->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['name' => '标题']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['name', '公告名称','link',url('edit',['id'=>'__id__'])],
                ['content', '公告内容', 'text.edit'],
                ['link', '公告地址', 'text.edit'],
                ['retime', '发布时间', 'datetime'],
                ['status','公告状态', 'status','',['开启', '关闭']],
                ['gongzhan','是否展示到首页','status','',['不展示','展示']],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('add,delete')
            ->addTopButtons('enable',['status'])
            ->addTopButtons('disable',['status'])
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
                $res = Db::name('home_notice')->update($data);
            }else{
               $res = Db::name('home_notice')->insert($data);
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
           $info = Db::name('home_notice')->find($id);
        }
        // 显示添加页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden','id'],
                ['text', 'name', '公告名称', '<span class="text-danger">必填</span>'],
                ['text', 'content', '公告内容', '<span class="text-danger">必填</span>'],
                ['text', 'link', '公告地址', '<span class="text-danger">选填</span>'],
                ['datetime', 'retime', '发布时间', '<span class="text-danger">必填</span>'],
                ['radio', 'status', '公告状态', '', ['开启', '关闭'], 0],
                ['radio', 'gongzhan', '是否展示到首页', '', ['不展示', '展示'], 0]
            ])
            ->layout(['name' => 2, 'content' => 3, 'retime' => 3, 'status' => 2])
            ->fetch();

    }
    //编辑
    public function edit($id = null){
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $data['retime'] = time();
            if ($gong = Db::name('home_notice')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功','index');
            }else{
                $this->error('编辑失败');
            }
        }
        $info = Db::name('home_notice')->find($id);
        return ZBuilder::make('form')
            ->addFormItems([
                    ['hidden','id'],
                    ['text','name','公告名称'],
                    ['text','content','公告内容'],
                    ['text','link','公告地址'],
                    ['datetime','retime','发布时间'],
                    ['radio','status', '公告状态', '', ['开启', '关闭']],
                    ['radio','gongzhan', '是否展示到首页', '', ['不展示', '展示']]
                ])
            ->setFormData($info)
            ->layout(['name' => 2, 'content' => 3, 'link'=>3, 'retime' => 3, 'status' => 2])
            ->fetch();
    }
}