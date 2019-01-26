<?php
/**
 * Created by PhpStorm.
 * User: dw
 * Date: 2019/1/25
 * Time: 16:17
 */

namespace app\user\admin;

use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use think\Db;

class Recharge  extends Admin
{
    public function index()
    {
        $map = $this->getMap();
        $info=Db::name('user_recharge')->select();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
//            ->setTableName('user_Withdrawals')
            ->setPageTitle('提现管理') // 设置页面标题
//            ->setTableName('user_Withdrawals') // 设置数据表名
            ->setSearch(['user_id' => '用户ID', 'order_sn' => '订单号']) // 设置搜索参数
            ->addColumns([ // 批量添加列
                ['user_id', '用户ID'],
                ['order_sn', '订单号'],
//                ['bank_name', '银行名称'],
//                ['account_bank', '银行账号'],
//                ['account_name', '开户人名称'],
                ['price', '充值金额'],
                ['pay_type', '状态','status','',[0=>'微信','支付宝','银联']],
                ['pay_status', '状态','status','',[0=>'支付失败','支付成功']],
                ['pay_time', '充值时间','datetime'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('delete') // 批量添加顶部按钮
            ->addRightButtons(['delete']) // 批量添加右侧按钮
            ->setRowList($info) // 设置表格数据
            ->fetch(); // 渲染页面
    }
}