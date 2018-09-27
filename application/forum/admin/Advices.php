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



namespace app\forum\admin;

use think\Db;

use app\admin\controller\Admin;

use app\common\builder\ZBuilder;

/**
* 消息下面的轮播
*/
class Advices extends Admin
{
   //index
    public function index(){
   	   $map = $this->getMap();
       $data_list = Db::name('forum_advices')
                    ->where($map)->order('sort asc')->paginate();
                    // print_r($data_list);die;
       return ZBuilder::make('table')
            ->addColumns([
                ['id','ID','link',url('edit',['id'=>'__id__'])],
                ['name','名称','link',url('edit',['id'=>'__id__'])],
                ['image','轮播图','img_url'],
                ['sort','排序','text.edit'],
                ['url','地址','text.edit'],
                ['status','状态', 'status','',['关闭', '开启']],
                ['guan','状态', 'switch'],
                ['right_button', '操作', 'btn']
           	])
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    //新增
    public function add(){
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            if ($result = Db::name('forum_advices')->insert($data)) {
                $this->success('添加成功', 'index');
            } else {
                $this->error('添加失败');
            }
        }
        // 显示编辑页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden', 'id'],
                ['text', 'name', '名称'],
                ['text','url','地址'],
                ['number', 'sort', '版块排序','','从小到大的排序'],
                ['radio', 'status', '状态', '', [ '关闭','开启'], 1],
                ['radio', 'guan', '是否在前台显示', '', [ '否','是'], 1],
                ['image', 'image', '图片', '<span class="text-danger">图片大小为750x180</span>']
            ])
            ->layout(['sid' => 2, 'name' => 3,'url'=>5,'sort'=>3,'status'=>3])
            ->fetch();
    }
    //编辑
    public function edit($id = null){
        if ($id === null) $this->error('缺少参数');
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            if ($advert = Db::name('forum_advices')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('forum_advices')->find($id);
        // 显示编辑页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden', 'id'],
                ['text', 'name', '名称'],
                ['text','url','地址'],
                ['number', 'sort', '分类排序','','从小到大的排序'],
                ['radio', 'status', '状态', '', [ '关闭','开启']],
                ['radio', 'guan', '是否在前台显示', '', [ '否','是']],
                ['image', 'image', '图片', '<span class="text-danger">图片大小为750x180</span>']
            ])
            ->setFormData($info)
            ->layout(['sid' => 2, 'name' => 3,'url'=>5,'sort'=>3,'status'=>3])
            ->fetch();
    }

}