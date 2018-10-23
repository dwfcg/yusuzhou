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



namespace app\shop\admin;

use think\Db;

use app\admin\controller\Admin;

use app\common\builder\ZBuilder;

use app\shop\model\Though as ThoughModel;

use util\Tree;



/**

 * 控制器

 * @package app\cms\admin

 */

class Though extends Admin

{

    /**

     * 列表

     * @author Lieber

     * @return mixed

     */
    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 数据列表
        $data_list = ThoughModel::where($map)->column(true);
        if (empty($map)) {

            $data_list = Tree::config(['title' => 'name'])->toList($data_list);

        }
        // 自定义按钮
        $btnMove = [

            'class' => 'btn btn-xs btn-default js-move-column',

            'icon'  => 'fa fa-fw fa-arrow-circle-right',

            'title' => '移动栏目'

        ];
        $btnAdd = [

            'class' => 'btn btn-xs btn-default',

            'icon'  => 'fa fa-fw fa-plus',

            'title' => '新增子栏目',

            'href'  => url('add', ['pid' => '__id__'])

        ];
       // $data_list = Db::name('shop_category')->where($map)->order('sort asc')->paginate();
        // 使用ZBuilder快速创建数据表格

        return ZBuilder::make('table')

            ->setSearch(['name' => '皮色']) // 设置搜索框

            ->addColumns([ // 批量添加数据列

                ['id', 'ID'],

                ['name', '皮色名称', 'callback', function($value, $data){

                   return isset($data['title_prefix']) ? $data['title_display'] : $value;

               }, '__data__','','text.edit'],

                ['status', '状态', 'switch'],

                ['right_button', '操作', 'btn']

            ])
            ->addTopButtons('add,delete')
            ->addRightButton('custom', $btnAdd)
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板

    }
    /**

     * 新增

     * @author Lieber

     * @return mixed

     */

    public function add($pid = 0)
    {
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            $data['update_time'] = time();
            if ($advert = Db::name('shop_though')->insert($data)) {
                $this->success('新增成功', 'index');
            } else {
                $this->error('新增失败');
            }
        }
        $lists =  ThoughModel::getTreeList();
        // 显示添加页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['select', 'pid', '所属分类', '<span class="text-danger">必选</span>', $lists, $pid],
                ['text', 'name', '皮色名称'],
                ['radio', 'status', '状态', '', ['停用', '启用'], 1]

            ])
            ->layout(['pid' => 2, 'name' => 4, 'sort' => 2])
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
            if ($advert = Db::name('shop_though')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('shop_though')->find($id);
        // 显示编辑页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden', 'id'],
                ['select', 'pid', '所属分类', '<span class="text-danger">必选</span>', ThoughModel::getTreeList($id)],
                ['text', 'name', '皮色名称'],
                ['radio', 'status', '状态', '', ['停用', '启用'], 1]

            ])

            ->setFormData($info)
            ->layout(['pid' => 2, 'name' => 4, 'sort' => 2])
            ->fetch();

    }

}