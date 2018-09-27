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



namespace app\collect\admin;

use think\Db;

use app\admin\controller\Admin;

use app\common\builder\ZBuilder;

use app\collect\model\Region as RegionModel;

use app\collect\model\Address as AddressModel;



/**

 * 版块控制器

 * @package app\cms\admin

 */

class Order extends Admin

{

    /**

     * 版块列表

     * @author Lieber

     * @return mixed

     */

    public function index()

    {

        // 查询

        $map = $this->getMap();

        // 数据列表

        $data_list = Db::name('collect_order')->alias('a')
        
        ->join("collect_good b","a.goods_id=b.id")

        ->join('user c','a.user_id=c.id')
        ->join('address d','a.address_id=d.address_id')
        ->where($map)

        ->field("a.*,b.title,b.images,c.name,c.headimg,d.consignee, d.sheng, d.shi, d.xian, d.address, d.mobile")

        ->order('a.add_time desc')->paginate();

        // dump($data_list);exit;

        // 使用ZBuilder快速创建数据表格

        return ZBuilder::make('table')

            ->setSearch(['title' => '标题']) // 设置搜索框

            ->addColumns([ // 批量添加数据列

                ['id', 'ID'],

                ['order_sn', '订单号'],

                ['price', '金额','link',url('edit',['id'=>'__id__'])],

                ['title', '商品名称'],

                ['images', '商品图','img_url'],

                ['name', '下单用户'],

                // ['headimg', '用户头像','img_url'],

                ['consignee', '定制人'],

                ['mobile', '手机'],

                ['sheng', '省份'],

                ['shi', '市'],

                ['xian', '县（区）'],

                ['address', '地址'],

                ['pay_type','支付方式','status','',['微信','支付宝']],
                ['pay_status', '支付状态', 'status','',['未支付', '已支付']],
                ['add_time','下单时间','datetime'],
                ['right_button', '操作', 'btn']

            ])

            ->addTopButtons('add,enable,disable,delete')

            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])

            ->setRowList($data_list)

            ->fetch(); // 渲染模板

    }

    

   

    public function edit($id = null)

    {

        if ($id === null) $this->error('缺少参数');
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            if ($advert = Db::name('collect_order')->where('id',$data['id'])->update($data)) {
                // var_dump($advert);die;
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('collect_order')->find($id);
        $goods = Db::name('collect_good')->find($info['goods_id']);
        $address = Db::name('address')->find($info['address_id']);
        $pics = explode(",",$goods['images']);

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