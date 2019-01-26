<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/19
 * Time: 9:08
 */

namespace app\user\admin;


use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use think\Db;

class Withdrawals   extends Admin
{
    public function index()
    {
        $map = $this->getMap();
        $info=Db::name('user_withdrawals')->where($map)->select();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
//            ->setTableName('user_Withdrawals')
            ->setPageTitle('提现管理') // 设置页面标题
//            ->setTableName('user_Withdrawals') // 设置数据表名
            ->setSearch(['account_bank' => '银行账号', 'account_name' => '开户人名称']) // 设置搜索参数
            ->addColumns([ // 批量添加列
                ['user_id', '用户ID'],

                ['bank_name', '银行名称'],
                ['account_bank', '银行账号'],
                ['account_name', '开户人名称'],
                ['money', '提现金额'],
                ['remark', '提现备注'],

                ['create_time', '申请提现时间','datetime'],
                ['status', '状态','status','',[0=>'处理中','处理成功','处理失败']],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('delete') // 批量添加顶部按钮
            ->addRightButtons(['edit','delete']) // 批量添加右侧按钮
            ->setRowList($info) // 设置表格数据
            ->fetch(); // 渲染页面
    }
    public function edit($id = null)
    {
        // 保存数据
        if ($this->request->isPost()) {
            if ($id == null) $this->error('缺少参数');
            $data = $this->request->post();
            if ($user = Db::name('user_withdrawals')->where('id',$id)->update($data)) {
                $this->success('修改成功', url('index'));
            } else {
                $this->error('修改失败');
            }
        }
        $info=Db::name('user_withdrawals')->find($id);
        // 使用ZBuilder快速创建表单
        return ZBuilder::make('form')
//            ->setPageTitle('新增') // 设置页面标题
            ->addFormItems([ // 批量添加表单项
                ['radio', 'status','处理状态','',[0=>'处理中','处理成功','处理失败']],
            ])
            ->setFormData($info)
            ->layout(['username' => 6, 'nickname' => 6, 'role' => 3, 'email' => 3, 'password' => 3, 'mobile'=> 3])
            ->fetch();
    }
}