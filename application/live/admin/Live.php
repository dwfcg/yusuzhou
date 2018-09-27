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

class Live extends Admin
{
    /**
     * 分类列表
     * @author Lieber
     * @return mixed
     */
    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 数据列表
        $data_list = Db::name('live')->alias('a')
                    ->join('live_cate c','a.cid = c.id')
                    ->field('a.*,c.name')
                    ->where($map)
                    ->order('sort asc')
                    ->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['name' => '分类名称']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['title', '直播标题','link',url('edit',['id'=>'__id__'])],
                ['name','所属分类'],
                ['sort', '分类排序'],
                ['status', '分类状态','switch'],
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
            if ($advert = Db::name('live')->insert($data)) {
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
                ['ueditor', 'details', '直播详情', '<span class="text-danger">必填</span>'],
                ['text','partake','直播人气'],
                ['datetime','starttime','直播开始时间'],
                ['datetime','endtime','直播结束时间'],
                ['radio', 'niming', '是否开启匿名评论', '', ['关闭', '开启'], 0],
                ['radio', 'status', '直播状态', '', ['关闭', '开启'], 1]
            ])
            ->layout(['cid' => 2, 'title' => 3, 'sort' => 2, 'status' => 4])
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
            if ($advert = Db::name('live')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('live')->find($id);
        $cate = Db::name('live_cate')->order('sort asc')->column('id,name');
        // 显示编辑页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden', 'id'],
                ['select', 'cid', '所属分类','', $cate],
                ['text', 'title', '直播标题', '<span class="text-danger">必填</span>'],
                ['image', 'img', '直播海报图', '<span class="text-danger">必填</span>'],
                ['text', 'video', '直播url', '<span class="text-danger">必填</span>'],
                ['ueditor', 'details', '直播详情', '<span class="text-danger">必填</span>'],
                ['text','partake','直播人气'],
                ['datetime','starttime','直播开始时间'],
                ['datetime','endtime','直播结束时间'],
                ['radio', 'niming', '是否开启匿名评论', '', ['关闭', '开启'], 0],
                ['radio', 'status', '直播状态', '', ['关闭', '开启'], 1]
            ])
            ->setFormData($info)
            ->layout(['cid' => 2, 'title' => 3, 'sort' => 2, 'status' => 4])
            ->fetch();
    }

}