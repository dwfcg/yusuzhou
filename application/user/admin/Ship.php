<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/11
 * Time: 16:57
 */

namespace app\user\admin;


use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use think\Db;

class Ship  extends Admin
{
    public function index()
    {
        $map = $this->getMap();
      $info=Db::name('user_ship')->order('level asc')->select();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setPageTitle('会员管理') // 设置页面标题
            ->setTableName('user') // 设置数据表名
            ->setSearch(['id' => 'ID', 'name' => '会员名', 'mobile' => '手机号']) // 设置搜索参数
            ->addColumns([ // 批量添加列
                ['level', '会员等级'],
                ['name', '会员名称'],
                ['condition', '会员条件'],
                ['discount', '会员折扣'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('add,delete') // 批量添加顶部按钮
            ->addRightButtons(['edit','delete'=>['data-tips' => '删除后无法恢复。']]) // 批量添加右侧按钮
            ->setRowList($info) // 设置表格数据
            ->fetch(); // 渲染页面
    }
    public function add()
    {
        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post();
            // 验证
            $result = $this->validate($data, 'ship');
            if (true !== $result)
                $this->error($result);
            if ($user = Db::name('user_ship')->insert($data)) {
                $this->success('新增成功', url('index'));
            } else {
                $this->error('新增失败');
            }
        }
        // 使用ZBuilder快速创建表单
        return ZBuilder::make('form')
            ->setPageTitle('新增') // 设置页面标题
            ->addFormItems([ // 批量添加表单项
                ['text', 'name','会员名称'],
                ['text', 'condition','会员条件'],
                ['text', 'discount', '会员折扣：如95折就填写95'],
                ['text', 'level', '会员等级:如123456'],
            ])
            ->layout(['username' => 6, 'nickname' => 6, 'role' => 3, 'email' => 3, 'password' => 3, 'mobile'=> 3])
            ->fetch();
    }
    public function edit($id = null)
    {
        // 保存数据
        if ($this->request->isPost()) {
            if ($id == null) $this->error('缺少参数');
            $data = $this->request->post();
            // 验证
            $result = $this->validate($data, 'ship.update');
            if (true !== $result)
                $this->error($result);
            if ($user = Db::name('user_ship')->where('id',$id)->update($data)) {
                $this->success('修改成功', url('index'));
            } else {
                $this->error('修改失败');
            }
        }
        $info=Db::name('user_ship')->find($id);
        // 使用ZBuilder快速创建表单
        return ZBuilder::make('form')
            ->setPageTitle('新增') // 设置页面标题
            ->addFormItems([ // 批量添加表单项
                ['text', 'name','会员名称'],
                ['text', 'condition','会员条件'],
                ['text', 'discount', '会员折扣：如95折就填写95'],
                ['text', 'level', '会员等级:如123456'],
            ])
            ->setFormData($info)
            ->layout(['username' => 6, 'nickname' => 6, 'role' => 3, 'email' => 3, 'password' => 3, 'mobile'=> 3])
            ->fetch();
    }
}