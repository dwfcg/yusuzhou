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
* 分类轮播
*/
class Slide extends Admin
{
   //index
    public function index(){
   	   $map = $this->getMap();
       $data_list = Db::name('forum_slide')->alias('s')
                    ->join('forum_section t','s.sid=t.id')
                    ->field('s.*,t.tionname')
                    ->where($map)->order('sort asc')->paginate();
                    // print_r($data_list);die;
       $section = Db::name('forum_section')->column('id,tionname');
       return ZBuilder::make('table')
            ->addColumns([
                ['id','ID','link',url('edit',['id'=>'__id__'])],
                ['name','轮播图名称','link',url('edit',['id'=>'__id__'])],
                ['tionname','轮播分类'],
                ['img','轮播图','img_url'],
                ['sort','排序','text.edit'],
                ['link','地址','text.edit'],
                ['status','状态', 'status','',['关闭', '开启']],
                ['right_button', '操作', 'btn']
           	])
            ->addTopSelect('sid','版块',$section)
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    //苏州轮播图
    public function suzhou(){
       $map = $this->getMap();
       $map['sid'] ='2';
       $data_list = Db::name('forum_slide')->alias('s')
                    ->join('forum_section t','s.sid=t.id')
                    ->field('s.*,t.tionname')
                    ->where($map)->order('sort asc')->paginate();
                    // print_r($data_list);die;
       $section = Db::name('forum_section')->column('id,tionname');
       return ZBuilder::make('table')
            ->addColumns([
                ['id','ID','link',url('edit',['id'=>'__id__'])],
                ['name','轮播图名称','link',url('edit',['id'=>'__id__'])],
                ['tionname','轮播分类'],
                ['img','轮播图','img_url'],
                ['sort','排序','text.edit'],
                ['link','地址','text.edit'],
                ['status','状态', 'status','',['关闭', '开启']],
                ['right_button', '操作', 'btn']
            ])
            ->addTopSelect('sid','版块',$section)
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    //活动轮播图
    public function huo(){
       $map = $this->getMap();
       $map['sid'] = '7';
       $data_list = Db::name('forum_slide')->alias('s')
                    ->join('forum_section t','s.sid=t.id')
                    ->field('s.*,t.tionname')
                    ->where($map)->order('sort asc')->paginate();
                    // print_r($data_list);die;
       $section = Db::name('forum_section')->column('id,tionname');
       return ZBuilder::make('table')
            ->addColumns([
                ['id','ID','link',url('edit',['id'=>'__id__'])],
                ['name','轮播图名称','link',url('edit',['id'=>'__id__'])],
                ['tionname','轮播分类'],
                ['img','轮播图','img_url'],
                ['sort','排序','text.edit'],
                ['link','地址','text.edit'],
                ['status','状态', 'status','',['关闭', '开启']],
                ['right_button', '操作', 'btn']
            ])
            ->addTopSelect('sid','版块',$section)
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    //知识轮播图
    public function zhi(){
       $map = $this->getMap();
       $map['sid'] = '3';
       $data_list = Db::name('forum_slide')->alias('s')
                    ->join('forum_section t','s.sid=t.id')
                    ->field('s.*,t.tionname')
                    ->where($map)->order('sort asc')->paginate();
                    // print_r($data_list);die;
       $section = Db::name('forum_section')->column('id,tionname');
       return ZBuilder::make('table')
            ->addColumns([
                ['id','ID','link',url('edit',['id'=>'__id__'])],
                ['name','轮播图名称','link',url('edit',['id'=>'__id__'])],
                ['tionname','轮播分类'],
                ['img','轮播图','img_url'],
                ['sort','排序','text.edit'],
                ['link','地址','text.edit'],
                ['status','状态', 'status','',['关闭', '开启']],
                ['right_button', '操作', 'btn']
            ])
            ->addTopSelect('sid','版块',$section)
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    //社区论坛轮播图
    public function meet(){
       $map = $this->getMap();
       $map['sid'] = '12';
       $data_list = Db::name('forum_slide')->alias('s')
                    ->join('forum_section t','s.sid=t.id')
                    ->field('s.*,t.tionname')
                    ->where($map)->order('sort asc')->paginate();
                    // print_r($data_list);die;
       $section = Db::name('forum_section')->column('id,tionname');
       return ZBuilder::make('table')
            ->addColumns([
                ['id','ID','link',url('edit',['id'=>'__id__'])],
                ['name','轮播图名称','link',url('edit',['id'=>'__id__'])],
                ['tionname','轮播分类'],
                ['img','轮播图','img_url'],
                ['sort','排序','text.edit'],
                ['link','地址','text.edit'],
                ['status','状态', 'status','',['关闭', '开启']],
                ['right_button', '操作', 'btn']
            ])
            ->addTopSelect('sid','版块',$section)
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    //闲置轮播图
    public function xian(){
       $map = $this->getMap();
       $map['sid'] = '9';
       $data_list = Db::name('forum_slide')->alias('s')
                    ->join('forum_section t','s.sid=t.id')
                    ->field('s.*,t.tionname')
                    ->where($map)->order('sort asc')->paginate();
                    // print_r($data_list);die;
       $section = Db::name('forum_section')->column('id,tionname');
       return ZBuilder::make('table')
            ->addColumns([
                ['id','ID','link',url('edit',['id'=>'__id__'])],
                ['name','轮播图名称','link',url('edit',['id'=>'__id__'])],
                ['tionname','轮播分类'],
                ['img','轮播图','img_url'],
                ['sort','排序','text.edit'],
                ['link','地址','text.edit'],
                ['status','状态', 'status','',['关闭', '开启']],
                ['right_button', '操作', 'btn']
            ])
            ->addTopSelect('sid','版块',$section)
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    //口碑轮播图
    public function koutu(){
       $map = $this->getMap();
       $map['sid'] = '8';
       $data_list = Db::name('forum_slide')->alias('s')
                    ->join('forum_section t','s.sid=t.id')
                    ->field('s.*,t.tionname')
                    ->where($map)->order('sort asc')->paginate();
                    // print_r($data_list);die;
       $section = Db::name('forum_section')->column('id,tionname');
       return ZBuilder::make('table')
            ->addColumns([
                ['id','ID','link',url('edit',['id'=>'__id__'])],
                ['name','轮播图名称','link',url('edit',['id'=>'__id__'])],
                ['tionname','轮播分类'],
                ['img','轮播图','img_url'],
                ['sort','排序','text.edit'],
                ['link','地址','text.edit'],
                ['status','状态', 'status','',['关闭', '开启']],
                ['right_button', '操作', 'btn']
            ])
            ->addTopSelect('sid','版块',$section)
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
            $data['add_time'] = time();
            if ($result = Db::name('forum_slide')->insert($data)) {
                $this->success('添加成功', 'index');
            } else {
                $this->error('添加失败');
            }
        }
        $section = Db::name('forum_section')->column('id,tionname');
        // 显示编辑页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden', 'id'],
                ['select','sid','版块','请选择',$section],
                ['text', 'name', '轮播图名称'],
                ['text','link','地址'],
                ['number', 'sort', '版块排序','','从小到大的排序'],
                ['radio', 'status', '状态', '', [ '关闭','开启'], 1],
                ['image', 'img', '图片', '<span class="text-danger">图片大小必须为16:9比列</span>']
            ])
            ->layout(['sid' => 2, 'name' => 3,'link'=>5,'sort'=>3,'status'=>3])
            ->fetch();
    }
    //编辑
    public function edit($id = null){
        if ($id === null) $this->error('缺少参数');
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            if ($advert = Db::name('forum_slide')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('forum_slide')->find($id);
        $section = Db::name('forum_section')->order('sort asc')->column('id,tionname');
        // 显示编辑页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden', 'id'],
                ['select', 'sid', '所属板块','', $section],
                ['text', 'name', '轮播图名称'],
                ['text','link','地址'],
                ['number', 'sort', '分类排序','','从小到大的排序'],
                ['radio', 'status', '状态', '', [ '关闭','开启']],
                ['image', 'img', '图片', '<span class="text-danger">图片大小必须为16:9比列</span>']
            ])
            ->setFormData($info)
            ->layout(['sid' => 2, 'name' => 3,'link'=>5,'sort'=>3,'status'=>3])
            ->fetch();
    }

}