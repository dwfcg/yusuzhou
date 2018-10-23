<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/28
 * Time: 10:47
 */

namespace app\integralshop\admin;


use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use think\Db;

class Order extends Admin
{
    public function order()
    {
        // 查询
        $map = $this->getMap();
        // 数据列表
        $fied=['0'=>'待付款','1'=>'待发货','2'=>'待收货','3'=>'已完成','4'=>'已发货'];
        $data_list = Db::name('user_integral')->alias('a')
            ->join("integralshop_index b","a.integralshop_id=b.id")
            ->join('user c','a.user_id=c.id')
            ->join('address d','a.address_id=d.address_id')
            ->field("a.*,b.name as  title,b.images,b.status as bstatus,c.name,c.headimg,d.consignee, d.sheng, d.shi, d.xian, d.address, d.mobile")
            ->where($map)
            ->order('add_time desc')->paginate();
        // echo Db::table('shop_order')->getLastSql();die;
        // dump($data_list);exit;
        // 使用ZBuilder快速创建数据表格

        return ZBuilder::make('table')
            ->setSearch(['order_no'=>'订单号'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID','link',url('Order/sea',['id'=>'__id__'])],
                ['order_no', '订单号'],
                ['price', '金额','link',url('edit',['id'=>'__id__'])],
                ['title', '商品名称'],
                ['images', '商品图','img_url'],
                ['name', '下单用户'],
                ['consignee', '收货人'],
                ['mobile', '手机'],
                ['sheng', '省份'],
                ['shi', '市'],
                ['xian', '县（区）'],
                ['address', '地址'],
                ['status','订单状态','status','',['待付款','待发货','待收货','已完成','已发货']],
                ['bstatus','商品种类','status','',['0'=>'实物','1'=>'红包']],
                ['add_time','下单时间','datetime'],
                ['right_button', '操作', 'btn']

            ])
            ->addTopSelect('a.status','分类',$fied)
            ->addTopButton('delete', ['table' => 'user_integral']) // 删除
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。','table' => 'user_integral']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板


    }
    //单号查询
    public function sea($id=null)
    {
        if ($id === null) $this->error('缺少参数');
        $sd = Db::name('user_integral')->where(['id'=>$id])->find();
        $address = Db::name('order_delivery')->where(['id'=>$sd['express']])->find();

        $com = $address["code"];
        $nu = $sd["express_no"];
        // $context = "查询";
        // var_dump($com);
        // var_dump($nu);die;
        // $link="<a href='https://www.kuaidi100.com/chaxun?com=".$com."&nu=".$nu."'>".$context."</a >";
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
//            $address=Db::name('order_delivery')->where('id',$data['express'])->find();
//            $data['express']=$address['code'];
            if ($advert = Db::name('user_integral')->where('id',$data['id'])->update($data)) {
                // var_dump($advert);die;
                $this->success('编辑成功', 'order');
            } else {
                $this->error('编辑失败');
            }
        }
        $data_list = Db::name('user_integral')->alias('a')
            ->join("integralshop_index b","a.integralshop_id=b.id")
            ->join('user c','a.user_id=c.id')
            ->join('address d','a.address_id=d.address_id')
            ->field("a.*,b.name as  title,b.images,c.name,c.headimg,d.consignee, d.sheng, d.shi, d.xian, d.address, d.mobile")
            ->order('add_time desc')->find($id);
        // 显示编辑页面
        $address=Db::name('order_delivery')->select();
//        dump($address);
        $data=[];
        foreach ($address as $k => $v)
        {
            $data[$address[$k]['id']]=$address[$k]['name'];
        }
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden','id'],
                ['select', 'express', '物流公司','',$data],
                ['text', 'express_no', '物流编号'],
                ['radio', 'status', '完成之前请严格确认对方已收到货','',['4'=>'已发货']],
            ])
            ->setFormData($data_list)
            ->fetch();
        // ->fetch();

    }

}