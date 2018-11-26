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

class Good extends Admin

{

    /**

     * 私人订制列表

     * @author Lieber

     * @return mixed

     */

    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 数据列表
        $fied = Db::name('collect_category')->where('status',1)->column('id,name');

        $data_list = Db::name('collect_good')->alias('a')
                     ->join('collect_category b','a.cid = b.id')
                     ->field('a.*,b.name')
                     ->where($map)
                     ->order('add_time desc')
                     ->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题','price'=>'价格'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['title', '订制标题','link',url('edit',['id'=>'__id__'])],
                ['name', '分类名称'],
                ['price', '订制价格', 'text.edit'],
                ['srdz_status', '订制状态', 'status','',['待订制','已订制']],
                ['good_num','销量', 'text.edit'],
                ['good_click','点击量', 'text.edit'],
                // ['sku','库存', 'text.edit'],
                ['good_com','评论数', 'text.edit'],
                ['is_free','是否包邮',['是','否'],0],
                ['right_button', '操作', 'btn']

            ])
            ->addTopSelect('cid','分类',$fied)
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
            $data['add_time'] = time();
            if (Db::name('collect_good')->insert($data)) {
                $this->success('新增成功', 'index');
            } else {
                $this->error('新增失败');
            }
        }
        $cates = Db::name('collect_category')->where('status',1)->column('id,name');
        $though = Db::name('shop_though')->where('status',1)->column('id,name');
        // $cation = Db::name('shop_cation')->column('id,name');
        $kind = Db::name('shop_kind')->where('status',1)->column('id,name');
        // $theme = Db::name('shop_theme')->column('id,name');
        $origin = Db::name('shop_origin')->where('status',1)->column('id,name');
        $rock = Db::name('shop_rock')->where('status',1)->column('id,name');
        // 显示添加页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden','id'],
                ['text', 'title', '订制名称','请输入'],
                ['select','cid', '商品分类', '请选择',$cates],
                ['select','thoughid','属性皮色','请选择',$though],
                // ['select','cationid','属性分类','请选择',$cation],
                ['select','originid','属性产地','请选择',$origin],
                ['select','rockid','属性籽料','请选择',$rock],
                // ['select','themeid','属性题材','请选择',$theme],
                ['select','kindid','属性白度','请选择',$kind],
                ['text','weight','订制重量','请输入'],
                ['text','size','订制尺寸','请输入'],

                ['number', 'price', '订制价格','请输入'],
                ['tags', 'tags', '订制标签','请输入'],
                ['number', 'sort', '商品排序','','99'],
                ['number','good_num','销量'],
                ['number','good_click','点击量'],
                ['number','good_com','评论数'],
                ['radio', 'srdz_status', '订制状态', '', ['待订制','已订制'],0],
                ['radio','is_free','是否包邮','', ['是','否'], 0],

                // ['number','sku','库存'],

                ['images', 'images', '订制图片'],
                ['file','video','上传订制视频地址'],
                ['ueditor','content','订制简介']
            ])
            ->layout([
                'cid' => 2, 
                'tid'=>3,
                'thoughid'=>2,
                // 'cationid'=>3,
                'originid'=>2,
                'rockid'=>2,
                'srdz_status'=>2,
                // 'themeid'=>3,
                'kindid'=>2,
                'weight'=>2,
                'size'=>2,
//                'title' => 3,
//                'images'=>3,
//                'video'=>5,
                'price' => 2, 
                'tags' => 2,
                'status'=>3,
                'good_num'=>2,
                'good_click'=>2,
//                'sku'=>3,
//                'good_com'=>3,
                'is_free'=>2,
                'sort' => 2
                ])
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
            if ($advert = Db::name('collect_good')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $cates = Db::name('collect_category')->where('status',1)->column('id,name');
        $though = Db::name('shop_though')->where('status',1)->column('id,name');
        // $cation = Db::name('shop_cation')->column('id,name');
        $kind = Db::name('shop_kind')->where('status',1)->column('id,name');
        // $theme = Db::name('shop_theme')->column('id,name');
        $origin = Db::name('shop_origin')->where('status',1)->column('id,name');
        $rock = Db::name('shop_rock')->where('status',1)->column('id,name');
        $info = Db::name('collect_good')->find($id);
        // 显示编辑页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden','id'],
                ['text', 'title', '订制名称','请输入'],
                ['select','cid', '商品分类', '请选择',$cates],
                ['select','thoughid','属性皮色','请选择',$though],
                // ['select','cationid','属性分类','请选择',$cation],
                ['select','originid','属性产地','请选择',$origin],
                ['select','rockid','属性籽料','请选择',$rock],
                // ['select','themeid','属性题材','请选择',$theme],
                ['select','kindid','属性白度','请选择',$kind],
                ['text','weight','订制重量','请输入'],
                ['text','size','订制尺寸','请输入'],

                ['number', 'price', '订制价格','请输入'],

                ['tags', 'tags', '订制标签','请输入'],
                ['number', 'sort', '订制排序','','99'],
                ['number','good_num','销量'],
                ['number','good_click','点击量'],
                ['number','good_com','评论数'],
                ['radio','is_free','是否包邮','', ['是','否'], 0],
                ['radio', 'srdz_status', '订制状态', '', ['待订制','已订制']],

                // ['number','sku','库存'],


                ['images', 'images', '订制图片'],
                ['text', 'video', '上传订制视频地址'],
                ['file', 'video', '上传订制视频地址'],
                ['ueditor','content','订制简介']
            ])
            ->setFormData($info)
            ->layout([
                'cid'=>2,
                'tid'=>3,
                'thoughid'=>2,
                // 'cationid'=>3,
                'originid'=>2,
                'rockid'=>2,
                // 'themeid'=>3,
                'kindid'=>2,
                'weight'=>2,
//                'video'=>5,
                'size'=>2,
//                'title' => 3,
                'price' => 2, 
                'tags' => 2,
                'good_num'=>2,
                'good_click'=>2,
                'sku'=>3,
//                'good_com'=>3,
                'is_free'=>2,
                'sort' => 2
                ])
            ->fetch();

    }

}