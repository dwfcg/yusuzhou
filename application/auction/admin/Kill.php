<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/10
 * Time: 14:16
 */

namespace app\auction\admin;


use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use think\cache\driver\Redis;
use think\Db;
use app\auction\home\Kill as KillClass;

class Kill  extends Admin
{
    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 数据列表
        $data_list = Db::name('auction_kill')->where($map)->order('addtime desc')->select();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['title', '商品名称', 'text.edit'],
                ['imgs','商品图片','img_url'],
                ['price','当前价格'],
                ['start_time','开始时间','datetime'],
                ['end_time','结束时间','datetime'],
                ['status', '状态', 'status','',['上架', '下架','被抢购','流拍']],
                ['addtime', '创建时间', 'datetime'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('add,delete')
            ->addRightButton('edit')
            ->addRightButton('delete',['data-tips' => '删除后无法恢复。'])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    public function add()
    {
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
//            dump($data);die();
            $result = $this->validate($data,'kill');
            $data['start_time']=strtotime($data['start_time']);
            $data['end_time']=strtotime($data['end_time']);
            if(true !== $result){
                // 验证失败 输出错误信息
                $this->error($result);
            }
            $data['addtime'] = time();
            $advert = Db::name('auction_kill')->insertGetId($data);
//            若移植数据库确保auction——kill这个表的ID是从1开始自增的，否则报错
           $killclass=new KillClass();
           $re=$killclass->ruhuo($advert);
            if ($advert) {
                $this->success('新增失败', 'index');
            } else {
                $this->error('新增失败');
            }
        }
        //$info = Db::name('auction_goods')->find($id);
        // 显示添加页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden','id'],
                ['text', 'title', '商品名称'],
                ['images', 'imgs', '商品图片'],
                ['text', 'price', '当前价'],
                ['ueditor', 'content', '详情'],
                ['datetime','start_time','开始时间'],
                ['datetime','end_time','结束时间'],
                ['radio', 'status', '状态', '', ['上架', '下架','已被抢购'], 0]
            ])
            //->setFormData($info)
            ->layout(['title' => 2, 'tags' => 4, 'attrs' => 4, 'start_price' => 3, 'price' => 3, 'price_range' => 3, 'start_time' => 2, 'end_time' => 2,'partake'=>2,'bands'=>2])
            ->fetch();
    }
    //修改
    public function edit($id = null)
    {
        if ($id === null) $this->error('缺少参数');
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            $result = $this->validate($data,'kill.update');
            $data['start_time']=strtotime($data['start_time']);
            $data['end_time']=strtotime($data['end_time']);
            if(true !== $result){
                // 验证失败 输出错误信息
                $this->error($result);
            }
            if ($advert = Db::name('auction_kill')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('auction_kill')->find($id);
        // 显示添加页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden','id'],
                ['text', 'title', '商品名称'],
                ['images', 'imgs', '商品图片'],
                ['text', 'price', '当前价'],
                ['ueditor', 'content', '详情'],
                ['datetime','start_time','开始时间'],
                ['datetime','end_time','结束时间'],
                ['radio', 'status', '状态', '', ['上架', '下架'], 0]
            ])
            ->setFormData($info)
            ->layout(['title' => 2, 'tags' => 4, 'attrs' => 4, 'start_price' => 3, 'price' => 3, 'price_range' => 3, 'start_time' => 2, 'end_time' => 2,'partake'=>2,'bands'=>2])
            ->fetch();
    }
}