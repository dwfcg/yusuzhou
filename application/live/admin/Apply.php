<?php  

namespace app\live\admin;
use think\Db;
use app\admin\controller\Admin;
use app\common\builder\ZBuilder;

/**
* 申请直播控制器
*/
class Apply extends Admin
{

    //申请直播
    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 数据列表
        $data_list = Db::name('live_apply')->where($map)->order('add_time desc')->paginate();

        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['name', '用户姓名'],
                ['phone','用户手机号'],
                ['title','直播标题'],
                // ['applytime','直播日期','date'],
                // ['starttime','直播开始时间','datetime'],
                // ['endtime','直播结束时间','datetime'],
                ['add_time', '申请时间', 'datetime'],
                ['status', '审核状态', 'status','',['待审核', '审核中', '审核通过', '审核不通过']],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('add,enable,disable,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    /**
     * 新增

     * @return mixed

     */
    public function add()
    {
        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $data['add_time'] = time();
            if (Db::name('live_apply')->insert($data)) {
                $this->success('新增成功', url('index'));
            } else {
                $this->error('新增失败');
            }
        }
        // 使用ZBuilder快速创建表单
        return ZBuilder::make('form')
            ->setPageTitle('新增') // 设置页面标题
            ->addFormItems([ // 批量添加表单项
                ['text', 'name', '用户姓名', '必填'],
                ['text', 'phone', '手机号', '必填'],
                ['datetime', 'applytime', '直播日期', '必填'],
                ['time', 'starttime', '直播开始时间', '必填'],
                ['time', 'endtime', '直播结束时间', '必填'],
                ['text', 'title', '直播标题', '必填'],
                ['radio', 'status', '状态', '', ['待审核', '审核中', '审核通过', '审核不通过'], 0]
            ])
            ->layout(['name' => 3, 'phone' => 3, 'applytime' => 3, 'starttime' => 3, 'endtime' => 3, 'content' => 3])
            ->fetch();
    }
    //编辑
    public function edit($id = null){
        if ($id === null) $this->error('缺少参数');
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            if ($advert = Db::name('live_apply')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('live_apply')->find($id);
        return ZBuilder::make('form')
            ->addFormItems([
                   ['hidden','id'],
                   ['text','name','用户姓名'],
                   ['text','phone','手机号'],
                   ['text','title','直播内容'],
                   ['datetime', 'applytime', '直播日期', '必填'],
                   ['time', 'starttime', '直播开始时间', '必填'],
                   ['time', 'endtime', '直播结束时间', '必填'],
                   ['radio', 'status', '状态', '', ['待审核', '审核中', '审核通过', '审核不通过'], 0]
                ])
            ->setFormData($info)
            ->layout(['name' => 3, 'phone' => 3, 'applytime' => 3, 'starttime' => 3, 'endtime' => 3, 'content' => 3])
            ->fetch();
    }
}