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



namespace app\collect\admin;

use think\Db;

use app\admin\controller\Admin;

use app\common\builder\ZBuilder;



/**

 * 版块控制器

 * @package app\cms\admin

 */

class Slider extends Admin

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

        $data_list = Db::name('collect_slider')->where($map)->order('sort asc')->paginate();

        // 使用ZBuilder快速创建数据表格

        return ZBuilder::make('table')

            ->addColumns([ // 批量添加数据列

                ['id', 'ID'],

                ['title', '标题', 'text.edit'],

                ['img', '图片', 'img_url'],

                ['url', '链接', 'text.edit'],

                ['sort', '排序', 'text.edit'],

                ['status', '状态', 'switch'],

                ['right_button', '操作', 'btn']

            ])

            ->addTopButtons('add,enable,disable,delete')

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

            if ($advert = Db::name('collect_slider')->insert($data)) {

                $this->success('新增成功', 'index');

            } else {

                $this->error('新增失败');

            }

        }



        // 显示添加页面

        return ZBuilder::make('form')

            ->addFormItems([

                ['text','title', '标题'],

                ['text', 'url', '链接'],

                ['image', 'img', '图片'],

                ['number', 'sort', '排序','','从小到大的排序'],

                ['radio', 'status', '状态', '', ['停用', '启用'], 1]

            ])
            ->layout(['title' => 2, 'url' => 3, 'img' => 6, 'sort' => 2])
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

            if ($advert = Db::name('collect_slider')->where('id',$data['id'])->update($data)) {

                $this->success('编辑成功', 'index');

            } else {

                $this->error('编辑失败');

            }

        }



        $info = Db::name('collect_slider')->find($id);



        // 显示编辑页面

        return ZBuilder::make('form')

            ->addFormItems([

                ['hidden','id'],

                ['text','title', '标题'],

                ['text', 'url', '链接'],

                ['image', 'img', '图片'],

                ['number', 'sort', '排序','','从小到大的排序'],

                ['radio', 'status', '状态', '', ['停用', '启用'], 1]

            ])

            ->setFormData($info)
            ->layout(['title' => 2, 'url' => 3, 'img' => 6, 'sort' => 2])
            ->fetch();

    }

}