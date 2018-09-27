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

namespace app\live\admin;
use think\Db;
use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
/**
 * 分类控制器
 * @package app\cms\admin
 */
class Cate extends Admin
{
    /**
     * 直播分类列表
     * @author Lieber
     * @return mixed
     */
    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 数据列表
        $data_list = Db::name('live_cate')
                    ->where($map)
                    ->order('sort asc')
                    ->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['name' => '分类名称']) // 设置搜索框
            ->addColumns([ // 批量添加数据列

                ['id', 'ID'],
                ['name', '分类名称','link',url('edit',['id'=>'__id__'])],
                ['sort', '分类排序'],
                ['status', '分类状态','status','',['关闭','开启']],
                ['kaiguan', '是否展示在前台','switch'],
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
            if ($advert = Db::name('live_cate')->insert($data)) {
                $this->success('新增成功', 'index');
            } else {
                $this->error('新增失败');
            }
        }
        // 显示添加页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['text', 'name', '分类名称', '<span class="text-danger">必填</span>'],
                ['number', 'sort', '分类排序','','从小到大的排序'],
                ['radio', 'status', '分类状态', '', ['关闭', '开启'], 1],
                ['radio', 'kaiguan', '是否展示在前台', '', ['关闭', '开启'], 1]
            ])
            ->layout(['name' => 2, 'sort' => 2, 'status' => 4])
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
            if ($advert = Db::name('live_cate')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('live_cate')->find($id);
        // 显示编辑页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden', 'id'],
                ['text', 'name', '分类名称', '<span class="text-danger">必填</span>'],
                ['number', 'sort', '分类排序','','从小到大的排序'],
                ['radio', 'status', '分类状态', '', ['关闭', '开启']],
                ['radio', 'kaiguan', '是否展示在前台', '', ['关闭', '开启']]
            ])
            ->setFormData($info)
            ->layout(['name' => 2, 'sort' => 2, 'status' => 4])
            ->fetch();
    }

}