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
        $data_list = Db::name('auction_order')->alias('a')
        ->join('auction_goods b','a.gid=b.id')
        ->join('user c','a.uid=c.id')
        ->join('address d','a.dizhi_id=d.address_id')
        ->field("a.*,b.title,b.imgs,c.name,c.headimg,d.consignee, d.sheng, d.shi, d.xian, d.address, d.mobile")
        ->where($map)
        ->order('add_time desc')->paginate();
        // echo Db::table('shop_order')->getLastSql();die;
        // dump($data_list);exit;
        // 使用ZBuilder快速创建数据表格

        return ZBuilder::make('table')
            ->setSearch(['title' => '商品名称','order_sn'=>'订单号','name'=>'下单用户'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID','link',url('Order/sea',['id'=>'__id__'])],
                ['order_sn', '订单号'],
                ['price', '最终价格','link',url('edit',['id'=>'__id__'])],
                ['title', '商品名称'],
                ['imgs', '商品图','img_url'],
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
            ->addTopButtons('add,enable,disable,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板

    }
    //单号查询
    public function sea($id=null)
    {
        if ($id === null) $this->error('缺少参数');
        $sd = Db::name('auction_order')->where(['id'=>$id])->find();
        $com = $sd["express"];
        $nu = $sd["express_no"];
        // $context = "查询";
        // var_dump($com);
        // var_dump($nu);die;
        // $link="<a href='https://www.kuaidi100.com/chaxun?com=".$com."&nu=".$nu."'>".$context."</a >";
        return $this->redirect("https://www.kuaidi100.com/chaxun?com=".$com."&nu=".$nu."");
        // echo $link;
    }
    //编辑
    public function edit($id = null)
    {
        if ($id === null) $this->error('缺少参数');
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            if ($advert = Db::name('auction_order')->where('id',$data['id'])->update($data)) {
                // var_dump($advert);die;
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('auction_order')->find($id);
        $goods = Db::name('auction_goods')->find($info['gid']);
        $address = Db::name('address')->find($info['dizhi_id']);
        $pics = explode(",",$goods['imgs']);
        $goods['pic'] = $pics[0];
        $this->assign('info',$info);
        $this->assign('address',$address);
        $this->assign('goods',$goods);
   // 显示编辑页面
        return ZBuilder::make('form')

            ->fetch('edit');
            // ->fetch();

    }

}