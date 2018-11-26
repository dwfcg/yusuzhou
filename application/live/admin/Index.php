<?php

namespace app\live\admin;
use think\Db;
use app\admin\controller\Admin;
use app\common\builder\ZBuilder;

/**
 * 直播控制器
 * @package app\live\admin
 */
class Index extends Admin
{
    /**
     * 直播列表
     * @author Zain
     * 
     */
    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 数据列表
        $data_list = Db::name('live_index')->alias('a')
                    ->join('live_cate c','a.cid = c.id')
                    ->field('a.*,c.name')
                    ->where('videotype',1)
                    ->where($map)
                    ->order('sort asc')
                    ->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title'=>'标题','name' => '分类名称'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['title', '直播标题','link',url('edit',['id'=>'__id__'])],
                ['name','所属分类'],
                ['sort', '排序'],
                ['status', '状态','status','',['关闭','开启','正在直播','没有直播']],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板

    }
    /**
     * 新增
     * @author Lieber
     * @return mixed
     */
    public function add()
    {
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            $data['addtime'] = time();
            if ($advert = Db::name('live_index')->insert($data)) {
                $this->success('新增成功', 'index');
            } else {
                $this->error('新增失败');
            }
        }
        $cate = Db::name('live_cate')->order('sort asc')->column('id,name');
        // 显示添加页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['select', 'cid', '所属分类','', $cate],
                ['text', 'title', '直播标题', '<span class="text-danger">必填</span>'],
                ['image', 'img', '直播海报图', '<span class="text-danger">必填</span>'],

                ['text', 'video', '直播url', '<span class="text-danger">必填</span>'],
                ['file','video','上传视频','<span class="text-danger">上传商品视频地址</span>'],
                ['text', 'details', '简介', '<span class="text-danger">必填</span>'],
                ['text','partake','人气'],
                ['datetime','starttime','直播开始时间'],
                ['datetime','endtime','直播结束时间'],
                ['radio', 'niming', '是否开启匿名评论', '', ['关闭', '开启'], 0],
                ['radio', 'status', '状态', '', ['关闭', '开启'], 1],
                ['radio', 'videotype', '分类', '', ['直播', '视频'], 1],
            ])
            ->layout(['cid' => 2, 'title' => 4,'video'=>4, 'sort' => 2, 'status' => 4])
            ->fetch();
    }
    /**
     * 编辑
     * @param null $id 广告id
     * @author Lieber
     * @return mixed
     */
    public function edit($id = null)
    {
        if ($id === null) $this->error('缺少参数');
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            $data['addtime'] = time();
            if ($advert = Db::name('live_index')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('live_index')->find($id);
        $cate = Db::name('live_cate')->order('sort asc')->column('id,name');
        // 显示编辑页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden', 'id'],
                ['select', 'cid', '所属分类','', $cate],
                ['text', 'title', '直播标题', '<span class="text-danger">必填</span>'],
                ['image', 'img', '直播海报图', '<span class="text-danger">必填</span>'],
                ['text', 'video', 'url', '<span class="text-danger">必填</span>'],
                ['file', 'video', 'url', '<span class="text-danger">必填</span>'],
                ['text', 'details', '简介', '<span class="text-danger">必填</span>'],
                ['text','partake','人气'],
                ['datetime','starttime','直播开始时间'],
                ['datetime','endtime','直播结束时间'],
                ['radio', 'niming', '是否开启匿名评论', '', ['关闭', '开启'], 0],
                ['radio', 'status', '状态', '', ['关闭', '开启'], 1]
            ])
            ->setFormData($info)
            ->layout(['cid' => 2, 'title' => 4,'video'=>4, 'sort' => 2, 'status' => 4])
            ->fetch();
    }

}