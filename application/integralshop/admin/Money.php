<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/28
 * Time: 13:14
 */

namespace app\integralshop\admin;


use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use think\Db;

class Money     extends Admin
{
    public function index()
    {
        $data=Db::name('integralshop_index')->order('id asc')->where('integralcatg',1)->select();
        return ZBuilder::make('table')
            ->addColumns([ // 批量添加列
                ['id', 'ID'],
                ['name', '名称','text'],
                ['money', '红包','text'],
                ['images', '图片','img_url'],
                ['price', '商品积分','text'],
                ['status', '上架/下架','switch'],
                ['right_button', '操作', 'btn'],

            ])
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data)
            ->fetch();
    }
    public function add()
    {
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            if ($advert = Db::name('integralshop_index')->insert($data)) {
                $this->success('新增成功', 'index');
            } else {
                $this->error('新增失败');
            }
        }
        // 显示添加页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['text','name', '红包名称'],
                ['text','money', '红包：如100，需是整数'],
                ['images','images', '图片展示'],
                ['text','comment', '图片描述'],
                ['text','price', '商品积分，如1000，严格填写'],
                ['text','num', '商品数量必须是整数'],
                ['radio','status', '上架/下架','',['1'=>'上架','0'=>'下架'],'1'],
                ['radio','integralcatg', '','',['1'=>'红包'],'1'],

            ])
//            ->layout(['title' => 2, 'url' => 3, 'img' => 6, 'sort' => 2])
            ->fetch();
    }
    public function edit($id = null)
    {
        if ($id === null) $this->error('缺少参数');
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            if ($advert = Db::name('integralshop_index')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('integralshop_index')->find($id);
//         显示编辑页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden','id'],
                ['text','name', '红包名称'],
                ['text','money', '红包：如100，需是整数'],
                ['images','images', '图片展示'],
                ['text','comment', '图片描述'],
                ['text','price', '商品积分，如1000，严格填写'],

                ['radio','status', '上架/下架','',['1'=>'上架','0'=>'下架'],'1'],
            ])
            ->setFormData($info)
//            ->layout(['title' => 2, 'url' => 3, 'img' => 6, 'sort' => 2])
            ->fetch();
    }
}