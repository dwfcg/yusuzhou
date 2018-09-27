<?php



namespace app\auction\admin;

use think\Db;

use app\admin\controller\Admin;

use app\common\builder\ZBuilder;



/**

 * 拍卖控制器

 * @package app\live\admin

 */

class Good extends Admin
{
    public function config()
    {
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            if($data['id']){
                $res = Db::name('auction_config')->update($data);
            }
            if ($res) {
                $this->success('操作成功', 'index');
            } else {
                $this->error('操作失败');
            }
        }
        $info = Db::name('auction_config')->find(1);
        return ZBuilder::make('form')
            ->setPageTitle('基础配置')
            ->addFormItems([
                ['hidden','id'],
                ['textarea', 'rule', '保证金规则','例如：保证金金额=可出价总额（19=2000），一行一个'],
                ['ueditor', 'rule_info', '规则详情'],
            ])
            ->setFormData($info)
            ->fetch();
    }

    public function order()
    {
        // 查询
        $map = $this->getMap();
        // 数据列表
        $map['status'] = 1;
        $data_list = Db::name('auction_order')->where($map)->order('addtime desc')->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['order_sn','订单号'],
                ['title', '商品名称'],
                ['name','用户名'],
                ['money','当前价格'],
                ['status', '状态', 'status','',['', '开启']],
                ['addtime', '创建时间', 'datetime'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('delete')
            ->addRightButton('edit', ['href' => url('order_edit', ['id' => '__id__'])])
            ->addRightButton('delete',['data-tips' => '删除后无法恢复。'])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    public function order_edit($id = null)
    {
        if ($id === null) $this->error('缺少参数');
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            if ($advert = Db::name('auction_order')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('auction_order')->find($id);
        $goods = Db::name('auction_goods')->find($info['gid']);
        $address = Db::name('address')->find($info['address_id']);
        $pics = explode(",",$goods['imgs']);
        $goods['pic'] = $pics[0];
        $this->assign('info',$info);
        $this->assign('address',$address);
        $this->assign('goods',$goods);
        // 显示编辑页面
        return ZBuilder::make('form')
            ->fetch('edit');
    }
}