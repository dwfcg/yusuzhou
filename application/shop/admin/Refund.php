<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/12
 * Time: 17:06
 */

namespace app\shop\admin;
use app\admin\controller\Admin;
use think\Db;
use app\common\builder\ZBuilder;
use app\shop\model\Region as RegionModel;
use app\shop\model\Address as AddressModel;
class Refund    extends Admin
{
    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 数据列表
        $data_list = Db::name('shop_order')->alias('a')
            ->join("shop_goods b","a.goods_id=b.id")
            ->join("shop_refund q","a.order_sn=q.order_sn")
            ->join('user c','a.user_id=c.id')
            ->field("a.order_sn,a.price,b.title,b.images,c.name,q.id,q.status,q.add_time")
            ->where($map)
            ->where('order_status',0)
            ->order('q.add_time desc')->paginate();
        // echo Db::table('shop_order')->getLastSql();die;
        // dump($data_list);exit;
        // 使用ZBuilder快速创建数据表格

        return ZBuilder::make('table')
            ->setSearch(['title' => '商品名称','order_sn'=>'订单号','name'=>'下单用户'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID','link',url('sea',['id'=>'__id__'])],
                ['order_sn', '订单号'],
                ['price', '金额'],
                ['title', '商品名称'],
                ['images', '商品图','img_url'],
                ['name', '下单用户'],
                ['status','订单状态','status','',['申请退款','拒绝','同意','对方已发货','已退款']],
                ['add_time','下单时间','datetime'],
                ['right_button', '操作', 'btn']

            ])
            ->addTopButtons('delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板

    }
    public function sea($id=null)
    {
        if ($id === null) $this->error('缺少参数');
        $sd = Db::name('shop_refund')->where(['id'=>$id])->find();
        $address = Db::name('order_delivery')->where(['id'=>$sd['express']])->find();

        $com = $address["code"];
        $nu = $sd["express_no"];
        return $this->redirect("https://www.kuaidi100.com/chaxun?com=".$com."&nu=".$nu."");
        // echo $link;
    }
    public function edit($id = null)
    {
        if ($id === null) $this->error('缺少参数');
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            $update=['status'=>$data['status']];
            $advert1 = Db::name('shop_refund')->where('id',$data['id'])->update($update);
            if ($advert1) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        dump($id);
        $info = Db::name('shop_order')->alias('a')
            ->join("shop_goods b","a.goods_id=b.id")
            ->join("shop_refund q","a.order_sn=q.order_sn")
            ->join('user c','a.user_id=c.id')
            ->field("a.order_sn,a.price,b.title,q.images,c.name,q.id,q.status,q.add_time,q.comment")
            ->where('q.id='.$id.'')
            ->find();
        $info['images']=array_filter(explode(',',$info['images']));
        $html='';
        foreach ($info['images'] as $k =>$v)
        {
            $html=$html.'<img  src="'.$info["images"][$k].'" height="150" width="150" />';
        }
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden','id'],
                ['static','order_sn', '订单编号'],
                ['static','title', '商品名称'],
                ['static','price', '订单价格'],
                ['static','name', '买主'],
                ['static','comment', '退款理由'],
                ['radio','status', '','', ['1' => '拒绝','2' => '同意']],
            ])
            ->setExtraHtml($html, 'form_top')
            ->addBtn('<a href="http://yusuzhou.youacloud.com/index.php/shop/refund/refund?order_sn='.$info['order_sn'].'"><button type="button" class="btn btn-default">退款</button></a>')
            ->setFormData($info)
            ->fetch();
    }

}