<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/26
 * Time: 16:23
 */

namespace app\shop\admin;


use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use think\Db;
use think\Image;

class Unuse extends Admin
{
    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 数据列表
        $fied=['0'=>'待审核','1'=>'通过','3'=>'已发货'];
        if(!$map)
        {
            $data=Db::name('shop_unuse')->where($map)->where('status','>',-1)->paginate();
        }else{
            $data=Db::name('shop_unuse')->where($map)->paginate();
        }

        // 使用ZBuilder构建数据表格
        return ZBuilder::make('table')
            ->addColumns([ // 批量添加列
                ['id', 'ID','link',url('unuse/sea',['id'=>'__id__'])],
                ['name', '商品名称'],
                ['images', '商品图片','img_url'],
                ['price', '价格'],
                ['status', '申请状态', 'status','',['待审核', '通过', '拒绝','对方已发货','收到']],
                ['right_button', '操作', 'btn'],


            ])
            ->addTopSelect('status','分类',$fied)
            ->addTopButtons('delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data)
            ->fetch();

    }
    public function editOrder($id = null)
    {
        if ($id === null) $this->error('缺少参数');
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            $addressinfo1=Db::name('region')->select();
            $addressdata=$this->getParents($addressinfo1,$data['area']);
//dump($addressdata);
            if($addressdata)
            {
                $whereaddress=[
                    'address'=>$data['address1'],
                    'sheng'=>$addressdata[1]['region_name'],
                    'shi'=>$addressdata[2]['region_name'],
                    'xian'=>$addressdata[3]['region_name'],
                    'consignee'=>$data['consignee'],
                    'mobile'=>$data['mobile']
                ];
            }else{
                $whereaddress=[
                    'address'=>$data['address1'],
                    'consignee'=>$data['consignee'],
                    'mobile'=>$data['mobile']
                ];
            }

//            dump($data);
            $whereorder=[
                'express'=>$data['express'],
                'express_no'=>$data['express_no'],
                'status'=>$data['status']
            ];
            $advert = Db::name('shop_order')->where('id',$data['id'])->find();
            $address=Db::name('address')->where('address_id',$advert['address_id'])->update($whereaddress);
            unset($data['address']);
            $advert1 = Db::name('shop_order')->where('id',$data['id'])->update($whereorder);
            if ($advert) {
                $this->success('编辑成功', 'orderInfo');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('shop_order')->alias('a')
            ->join("shop_unuse b","a.unuse_id=b.id")
            ->join('user c','a.user_id=c.id')
            ->join('address d','a.address_id=d.address_id')
            ->field("a.*,b.name as title,b.images,c.name,c.headimg,d.consignee, d.sheng, d.shi, d.xian, d.address, d.mobile")
            ->where('order_status',1)
            ->order('add_time desc')->find($id);
//         显示编辑页面
        $info['images']=array_filter(explode(',',$info['images']));
//        dump($info);
        $addressinfo=Db::name('packet_wechat_area')->select();
//        $info['sheng']=$addressinfo['sheng']
        $html = '<img  src="'.$info["images"][0].'" height="150" width="150" />';
        unset($info['images']);
        $address=Db::name('order_delivery')->select();
//        dump($info);
        $info['address']=$info['sheng'].$info['shi'].$info['xian'].$info['address'];
        $data=[];
        foreach ($address as $k => $v)
        {
            $data[$address[$k]['id']]=$address[$k]['name'];
        }
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden','id'],
                ['static','order_sn', '订单编号'],
                ['static','title', '商品名称'],
                ['static','price', '订单价格'],
                ['text','consignee', '收货人'],
                ['text','mobile', '手机号'],
                ['select', 'express', '物流公司','',$data],
                ['text', 'express_no', '物流编号'],
                ['static', 'address', '收货地址'],
                ['linkages', 'area', '修改收货地区', '', 'region', 4, '', ['pid' => 'parent_id','name' => 'region_name', 'id' => 'region_id']],

                ['text', 'address1', '修改收货地址'],
//                ['image','images', '订单编号'],

//                ['text','comment', '商品描述'],
//                ['images', 'images', '商品图片'],
                ['radio','status', '','', [ '0' => '待付款','1' => '待发货','2' => '已发货', '3' => '已完成'],0],
            ])
            ->setExtraHtml($html, 'form_top')
            ->setFormData($info)
//            ->layout(['title' => 2, 'url' => 3, 'img' => 6, 'sort' => 2])
            ->fetch();
    }
    public function add()
    {
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            if ($advert = Db::name('shop_unuse')->insert($data)) {
                $this->success('新增成功', 'index');
            } else {
                $this->error('新增失败');
            }
        }
        // 显示添加页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['text','name', '姓名'],
            ])
//            ->layout(['title' => 2, 'url' => 3, 'img' => 6, 'sort' => 2])
            ->fetch();
    }
    //单号查询
    public function sea($id=null)
    {
        if ($id === null) $this->error('缺少参数');
        $sd = Db::name('shop_unuse')->where(['id'=>$id])->find();
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
    public function orderInfo()
    {
        // 查询
        $map = $this->getMap();
        // 数据列表
        $data_list = Db::name('shop_order')->alias('a')
            ->join("shop_unuse b","a.unuse_id=b.id")
            ->join('user c','a.user_id=c.id')
            ->join('address d','a.address_id=d.address_id')
            ->field("a.*,b.name as title,b.images,c.name,c.headimg,d.consignee, d.sheng, d.shi, d.xian, d.address, d.mobile")
            ->where($map)
            ->where('order_status',1)
            ->order('add_time desc')->select();
        // echo Db::table('shop_order')->getLastSql();die;
        // dump($data_list);exit;
        // 使用ZBuilder快速创建数据表格

        return ZBuilder::make('table')
            ->setSearch(['b.name' => '商品名称','order_sn'=>'订单号','c.name'=>'下单用户'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID','link',url('Order/sea',['id'=>'__id__'])],
                ['order_sn', '订单号'],
                ['price', '金额'],
                ['title', '商品名称'],
                ['images', '商品图','img_url'],
                ['name', '下单用户'],
                ['consignee', '收货人'],
                ['mobile', '手机'],
                ['sheng', '省份'],
                ['shi', '市'],
                ['xian', '县（区）'],
                ['address', '地址'],
                ['pay_type','支付方式','status','',['微信','支付宝']],
                ['pay_status', '支付状态', 'status','',['未支付', '已支付']],
                ['status','订单状态','status','',['待付款','待发货','待收货','已完成','已评价']],
                ['add_time','下单时间','datetime'],
                ['right_button', '操作', 'btn']

            ])
            ->addRightButtons(['edit'=>['table' => 'shop_order','href' => url('editOrder', ['id' => '__id__'])], 'delete' => ['data-tips' => '删除后无法恢复。','table' => 'shop_order']])
            ->addTopButton('delete', ['table' => 'shop_order'])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板

    }
//    public function edit($id = '')
//    {
//        if ($id === null) $this->error('缺少参数');
//        // 保存数据
//        if ($this->request->isPost()) {
//            // 表单数据
//            $data = $this->request->post();
//            $data['add_time']=time();
//            if ($advert = Db::name('shop_unuse')->where('id',$data['id'])->update($data)) {
//                $this->success('编辑成功', 'index');
//            } else {
//                $this->error('编辑失败');
//            }
//        }
//        $info = Db::name('shop_unuse')->alias('a')
//            ->join('user c','a.user_id=c.id')
//            ->where('a.id',$id)
//            ->field('a.*,c.name as username')
//            ->find();
////      dump($info);
//        $addressinfo=Db::name('order_delivery')->find($info['express']);
//
//        $addressinfo1=Db::name('region')->select();
////        dump($addressinfo1);
////        $data=$this->getParents($addressinfo1,166);
////        dump($data);
//        $info['express']=$addressinfo['name'];
////        dump($addressinfo);
//        return ZBuilder::make('form')
//            ->addFormItems([
//                ['hidden','id'],
//                ['static','express', '快递公司'],
//                ['static', 'express_no', '物流编号'],
//                ['radio','recommend', '','', ['0' => '不推荐', '1' => '推荐']],
//                ['radio','status', '','', ['1' => '通过', '2' => '拒绝', '4' => '上架']],
//            ])
//
//            ->setFormData($info)
//            ->fetch();
//    }
    public function edit($id = '')
    {
        if ($id === null) $this->error('缺少参数');
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            $data['add_time']=time();
            if ($advert = Db::name('shop_unuse')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('shop_unuse')->alias('a')
            ->join('user c','a.user_id=c.id')
            ->where('a.id',$id)
            ->field('a.*,c.name as username')
            ->find($id);
        $info['images']=array_filter(explode(',',$info['images']));
        $html='';
        foreach ($info['images'] as $k =>$v)
        {
            $html=$html.'<img  src="'.$v.'" height="150" width="150" />';
        }
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden','id'],
                ['static','name', '商品名称'],
                ['static','comment', '详细描述'],
                ['radio','status', '','', ['1' => '通过', '2' => '拒绝','4'=>'收到货物']],
            ])
            ->setExtraHtml($html, 'form_top')
            ->setFormData($info)
            ->fetch();
    }

    public function getParents($categorys,$catId){
        $tree=array();
        foreach($categorys as $item)
        {
            if($item['region_id']==$catId)
            {
                if($item['parent_id']>0)
                    $tree=array_merge($tree,$this->getParents($categorys,$item['parent_id']));
                $tree[]=$item;
                break;
            }
        }
        return $tree;
    }
}