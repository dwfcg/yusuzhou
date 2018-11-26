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

namespace app\auction\admin;
use think\Db;
use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use app\shop\model\Region as RegionModel;
use app\shop\model\Address as AddressModel;

/**
 * 拍卖订单
 * @package app\cms\admin
 */

class Order extends Admin
{
    /**
     * 订单列表
     * @author Lieber
     * @return mixed
     */
    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 数据列表
        $data_list = Db::name('shop_order')->alias('a')
            ->join("auction_goods b","a.goods_id=b.id")
            ->join('user c','a.user_id=c.id')
            ->join('address d','a.address_id=d.address_id')
            ->field("a.*,b.title,b.imgs as images,c.name,c.headimg,d.consignee, d.sheng, d.shi, d.xian, d.address, d.mobile")
            ->where($map)
            ->where('order_status',3)
            ->order('add_time desc')->paginate();
        // echo Db::table('shop_order')->getLastSql();die;
        // dump($data_list);exit;
        // 使用ZBuilder快速创建数据表格

        return ZBuilder::make('table')
            ->setTableName('shop_order')
            ->setSearch(['title' => '商品名称','order_sn'=>'订单号','name'=>'下单用户'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID','link',url('Order/sea',['id'=>'__id__'])],
                ['order_sn', '订单号'],
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
                ['pay_type','支付方式','status','',['微信','支付宝']],
                ['pay_status', '支付状态', 'status','',['未支付', '已支付']],
                ['status','订单状态','status','',['待付款','待发货','待收货','已完成','已评价']],
                ['add_time','下单时间','datetime'],
                ['right_button', '操作', 'btn']

            ])
            ->addTopButtons('delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板

    }
    //单号查询
    public function sea($id=null)
    {
        if ($id === null) $this->error('缺少参数');
        $sd = Db::name('shop_order')->where(['id'=>$id])->find();
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
            $addressinfo1=Db::name('region')->select();
            $addressdata=$this->getParents($addressinfo1,$data['area']);
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
            if ($advert1||$address) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('shop_order')->alias('a')
            ->join("auction_goods b","a.goods_id=b.id")
            ->join('user c','a.user_id=c.id')
            ->join('address d','a.address_id=d.address_id')
            ->field("a.*,b.title,b.imgs as images,c.name,c.headimg,d.consignee, d.sheng, d.shi, d.xian, d.address, d.mobile")
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