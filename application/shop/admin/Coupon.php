<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/8
 * Time: 15:40
 */

namespace app\shop\admin;


use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use think\Db;

class Coupon    extends Admin
{
    public function index()
    {
        $map=$this->getMap();
        $data=Db::name('shop_coupon')->where($map)->order('add_time asc')->select();
        $btn_access = [
            'title' => '查看',
            'icon'  => 'fa fa-fw fa-key',
            'href'  => url('info', ['id' => '__id__'])
        ];
        return ZBuilder::make('table')
            ->addColumns([ // 批量添加列
                ['id', 'ID'],
                ['name', '优惠券名字','text.edit'],
                ['type', '优惠券类型', 'status','',['注册', '邀请', '免费领取']],
                ['money', '优惠券金额'],
                ['condition', '优惠券使用满减金额'],
                ['createnum', '优惠券发放数量'],
                ['send_num', '优惠券领取数量'],
                ['use_num', '优惠券使用数量'],
                ['right_button', '操作', 'btn'],
            ])
            ->addRightButtons(['edit','delete'])
            ->addRightButton('look', $btn_access)
            ->addTopButtons(['add','delete']) // 批量添加顶部按钮
            ->setRowList($data)
            ->fetch();
    }
    public function addEditCoupon()
    {
        $data = I('post.');
        $data['send_start_time'] = strtotime($data['send_start_time']);
        $data['send_end_time'] = strtotime($data['send_end_time']);
        $data['use_end_time'] = strtotime($data['use_end_time']);
        $data['use_start_time'] = strtotime($data['use_start_time']);
        $couponValidate = Loader::validate('Coupon');
        if (!$couponValidate->batch()->check($data)) {
            $this->ajaxReturn(['status' => 0, 'msg' => '操作失败', 'result' => $couponValidate->getError()]);
        }
        if(empty($data['goods_id']) && $data['use_type']==1)$this->ajaxReturn(['status' => -1, 'msg' => '请选择活动商品', 'result' => '']);
        if (empty($data['id'])) {
            $data['add_time'] = time();
            $row = Db::name('coupon')->insertGetId($data);
            //指定商品
            if ($data['use_type'] == 1) {
                foreach ($data['goods_id'] as $v) {
                    Db::name('goods_coupon')->add(['coupon_id' => $row, 'goods_id' => $v,'goods_category_id'=>0]);
                }
            }
            //指定商品分类id
            if ($data['use_type'] == 2) {
                Db::name('goods_coupon')->add(['coupon_id' => $row, 'goods_category_id' => $data['cat_id3']]);
            }
        } else {
            $row = M('coupon')->where(array('id' => $data['id']))->save($data);
            Db::name('goods_coupon')->where(['coupon_id'=>$data['id']])->delete();//先删除后添加
            //指定商品
            if ($data['use_type'] == 1) {
                foreach ($data['goods_id'] as $value) {
                    Db::name('goods_coupon')->add(['coupon_id' => $data['id'], 'goods_id' => $value]);
                }
            }
            //指定商品分类id
            if ($data['use_type'] == 2) {
                Db::name('goods_coupon')->add(['coupon_id' => $data['id'], 'goods_category_id' => $data['cat_id3']]);
            }
        }
        if ($row !== false) {
            $this->ajaxReturn(['status' => 1, 'msg' => '编辑代金券成功', 'result' => '']);
        } else {
            $this->ajaxReturn(['status' => 0, 'msg' => '编辑代金券失败', 'result' => '']);
        }
    }
    /*
    * 添加编辑一个优惠券类型
    */
    public function add()
    {
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            $result = $this->validate($data,'coupon');
            $data['send_start_time']=strtotime($data['send_start_time']);
            $data['send_end_time']=strtotime($data['send_end_time']);
            $data['use_start_time']=strtotime($data['use_start_time']);
            $data['use_end_time']=strtotime($data['use_end_time']);
            if(true !== $result){
                // 验证失败 输出错误信息
                $this->error($result);
            }
            $data['addtime'] = time();
            $advert = Db::name('shop_coupon')->insert($data);
            if ($advert) {
                $this->success('新增成功', 'index');
            } else {
                $this->error('新增失败');
            }
        }
        //$info = Db::name('auction_goods')->find($id);
        // 显示添加页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['text','name', '优惠券名字'],
                ['text','money', '优惠券金额'],
                ['text','condition', '消费金额'],
                ['text','createnum', '发放数量0则为无限制'],
                ['radio', 'type', '发放类型', '', ['注册','邀请','免费领取'], 0],
                ['datetime','send_start_time','发放开始时间'],
                ['datetime','send_end_time','发放结束时间'],
                ['datetime','use_start_time','使用开始时间'],
                ['datetime','use_end_time','使用结束时间'],
                ['radio', 'use_type', '商品范围', '', ['全店通用'], 0]
            ])
            //->setFormData($info)
            ->layout(['send_start_time' => 5, 'send_end_time' => 5, 'use_start_time' => 5, 'use_end_time' => 5])
            ->fetch();
    }
   public function edit($id = '')
   {
       // 保存数据
       if ($this->request->isPost()) {
           // 表单数据
           $data = $this->request->post();

           $result = $this->validate($data,'coupon.update');
           $data['send_start_time']=strtotime($data['send_start_time']);
           $data['send_end_time']=strtotime($data['send_end_time']);
           $data['use_start_time']=strtotime($data['use_start_time']);
           $data['use_end_time']=strtotime($data['use_end_time']);
           if(true !== $result){
               // 验证失败 输出错误信息
               $this->error($result);
           }
           $data['addtime'] = time();
           $advert = Db::name('shop_coupon')->where('id',$id)->update($data);
           if ($advert) {
               $this->success('新增成功', 'index');
           } else {
               $this->error('新增失败');
           }
       }
       $info = Db::name('shop_coupon')
           ->find();
       // 显示添加页面
       return ZBuilder::make('form')
           ->addFormItems([
               ['text','name', '优惠券名字'],
               ['text','money', '优惠券金额'],
               ['text','condition', '消费金额'],
               ['text','createnum', '发放数量0则为无限制'],
               ['radio', 'type', '发放类型', '', ['注册','邀请','免费领取'], 0],
               ['datetime','send_start_time','发放开始时间'],
               ['datetime','send_end_time','发放结束时间'],
               ['datetime','use_start_time','使用开始时间'],
               ['datetime','use_end_time','使用结束时间'],
               ['radio', 'use_type', '可使用商品', '', ['全店通用'], 0]
           ])
           ->setFormData($info)
           ->layout(['send_start_time' => 5, 'send_end_time' => 5, 'use_start_time' => 5, 'use_end_time' => 5])
           ->fetch();
   }

    public function info()
    {
        $data=input('id');
        $info = Db::name('shop_couponlist')->alias('a')
            ->join('user b','a.uid=b.id')
            ->join('shop_order c','a.order_id=c.id')
            ->join('shop_coupon d','a.cid=d.id')
            ->field('a.id,d.name as couponname,a.use_time,a.status,a.type,b.name,c.order_sn')
            ->where('a.cid',$data)
            ->select();
        if(!$info)
        {
            $info = Db::name('shop_couponlist')->alias('a')
                ->join('user b','a.uid=b.id')
                ->join('shop_coupon d','a.cid=d.id')
                ->field('a.id,d.name as couponname,a.use_time,a.status,a.type,b.name')
                ->where('a.cid',$data)
                ->select();
        }
        return ZBuilder::make('table')
            ->addColumns([ // 批量添加列
                ['id', 'ID'],
                ['couponname', '优惠券名字'],
                ['type', '优惠券类型', 'status','',['注册', '邀请', '免费领取']],
                ['name', '所属用户'],
                ['order_sn', '订单编号'],
                ['status', '是否使用', 'status','',['未使用', '已使用', '已过期']],
                ['right_button', '操作', 'btn'],
            ])
            ->addRightButtons(['delete'=>['table'=>'shop_couponlist','id'=>'__id__']])
            ->addTopButtons(['delete'=>['table'=>'shop_couponlist']]) // 批量添加顶部按钮
            ->setRowList($info)
            ->fetch();
    }

}