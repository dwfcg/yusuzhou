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
 * 版块控制器
 * @package app\cms\admin
 */
class Section extends Admin
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
        $data_list = Db::name('forum_section')->where($map)->order('sort asc')->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['tionname' => '板块名称']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['icon', '版块图标', 'img_url'],
                ['tionname', '版块名称', 'text.edit'],
                ['sort', '版块排序', 'text.edit'],
                ['examine', '发布审核', 'switch'],
                ['status', '版块状态', 'switch'],
                ['is_home', '首页显示', 'switch'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('add,delete')
            ->addTopButtons('enable',['status'])
            ->addTopButtons('disable',['status'])
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
            $data['update_time'] = time();
            if ($advert = Db::name('forum_section')->insert($data)) {
                $this->success('新增成功', 'index');
            } else {
                $this->error('新增失败');
            }
        }
        // 显示添加页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['text', 'tionname', '版块名称'],
                ['number', 'sort', '版块排序','','从小到大的排序'],
                ['image', 'icon', '版块图标'],
                ['radio', 'examine', '发布审核', '', ['停用', '启用'], 0],
                ['radio', 'status', '版块状态', '', ['停用', '启用'], 1],
                ['radio', 'is_home', '首页显示', '', ['停用', '启用'], 0]
            ])
            ->layout(['tionname' => 2 , 'sort' => 2, 'icon' => 6])
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
            $data['update_time'] = time();
            if ($advert = Db::name('forum_section')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('forum_section')->find($id);
        // 显示编辑页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden', 'id'],
                ['text', 'tionname', '版块名称'],
                ['number', 'sort', '版块排序','','从小到大的排序'],
                ['image', 'icon', '版块图标'],
                ['radio', 'examine', '发布审核', '', ['停用', '启用']],
                ['radio', 'status', '版块状态', '', ['停用', '启用']],
                ['radio', 'is_home', '首页显示', '', ['停用', '启用']]
            ])
            ->setFormData($info)
            ->layout(['tionname' => 2, 'sort' => 2, 'icon' => 6])
            ->fetch();
    }
}