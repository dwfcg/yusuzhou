<?php



namespace app\admin\controller;



use app\common\builder\ZBuilder;

use think\Db;





/**

 * 控制器

 * @package app\live\admin

 */

class Slide extends Admin

{

    /**

     * 列表

     * @author Zain

     * 

     */

    public function index()

    {

        // 查询

        $map = $this->getMap();

        // 数据列表

        $data_list = Db::name('slide')->where($map)->order('id desc')->paginate();



        // 使用ZBuilder快速创建数据表格

        return ZBuilder::make('table')

            ->setTableName('slide') 

            ->setSearch(['title' => '标题']) // 设置搜索框

            ->addColumns([ // 批量添加数据列

                ['id', 'ID'],

                ['name', '广告标题', 'text.edit'],

                ['img', '广告图片', 'img_url'],

                ['link', '广告地址', 'text.edit'],

                ['sort', '广告排序', 'text.edit'],

                ['status', '广告状态', 'status','',['关闭', '开启']],

                ['right_button', '操作', 'btn']

            ])

            ->addTopButtons('add,enable,disable,delete')

            ->addRightButton('edit', ['href' => url('add', ['id' => '__id__'])])

            ->addRightButton('delete',['data-tips' => '删除后无法恢复。'])

            ->setRowList($data_list)

            ->fetch(); // 渲染模板

    }

    

    /**

     * 新增

     * @author Zain

     * @return mixed

     */

    public function add($id = '')

    {

        // 保存数据

        if ($this->request->isPost()) {

            // 表单数据

            $data = $this->request->post();

            if($data['id']){

                $res = Db::name('slide')->update($data);

            }else{

           

               $res = Db::name('slide')->insert($data);

            }

            

            if ($res) {

                $this->success('操作成功', 'index');

            } else {

                $this->error('操作失败');

            }

        }

        

        if($id == ''){

            $title = '添加';

        }else{

            $title = '修改';

        }

        $info = Db::name('slide')->find($id);

        // 显示添加页面

        return ZBuilder::make('form')

            ->setPageTitle($title)

            ->addFormItems([

                ['hidden','id'],

                ['text', 'name', '广告名称', '<span class="text-danger">必填</span>'],

                ['image', 'img', '广告图片', '<span class="text-danger">必填</span>'],

                ['text','link','广告地址', '<span class="text-danger">必填</span>'],

                ['text','sort','广告排序'],

                ['radio', 'status', '广告状态', '', ['关闭', '开启'], 1]

            ])

            ->setFormData($info)
            ->layout(['name' => 4, 'img' => 6, 'link' => 4, 'sort' => 2])
            ->fetch();

    }



}