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

class Setintegral  extends Admin
{
    public function index()
    {
        $map = $this->getMap();
        $info=Db::name('user_setintegral')->select();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setTableName('user_setintegral')
            ->setPageTitle('会员管理') // 设置页面标题
            ->setTableName('user') // 设置数据表名
//            ->setSearch(['id' => 'ID', 'name' => '会员名', 'mobile' => '手机号']) // 设置搜索参数
            ->addColumns([ // 批量添加列
                ['releasetie', '发布帖子'],
                ['commenttie', '评价帖子'],
                ['buygoods', '购买商品'],
                ['commentgoods', '评价商品'],
                ['sign', '签到'],
                ['right_button', '操作', 'btn']
            ])
//            ->addTopButtons('a') // 批量添加顶部按钮
            ->addRightButtons(['edit']) // 批量添加右侧按钮
            ->setRowList($info) // 设置表格数据
            ->fetch(); // 渲染页面
    }
    public function edit($id = null)
    {
        // 保存数据
        if ($this->request->isPost()) {
            if ($id == null) $this->error('缺少参数');
            $data = $this->request->post();
            if ($user = Db::name('user_setintegral')->where('id',$id)->update($data)) {
                $this->success('修改成功', url('index'));
            } else {
                $this->error('修改失败');
            }
        }
        $info=Db::name('user_setintegral')->find($id);
        // 使用ZBuilder快速创建表单
        return ZBuilder::make('form')
            ->setPageTitle('新增') // 设置页面标题
            ->addFormItems([ // 批量添加表单项
                ['text', 'releasetie','发布帖子:整数'],
                ['text', 'commenttie','评价帖子:整数'],
                ['text', 'buygoods', '购买商品:整数'],
                ['text', 'commentgoods', '评价商品:整数'],
                ['text', 'sign', '签到:整数'],
            ])
            ->setFormData($info)
            ->layout(['username' => 6, 'nickname' => 6, 'role' => 3, 'email' => 3, 'password' => 3, 'mobile'=> 3])
            ->fetch();
    }
}