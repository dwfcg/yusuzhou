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



/**

 * 版块控制器

 * @package app\cms\admin

 */

class Goods extends Admin

{

    /**

     * 商品列表

     * @author Lieber

     * @return mixed

     */

    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 数据列表
        $fied = Db::name('shop_category')->where('status',1)->column('id,name');
        // $count = Db::name('shop_goods')->where('status',1)->count();
        $data_list = Db::name('shop_goods')->alias('a')
                     ->join('shop_category b','a.cid = b.id')
                     ->field('a.*,b.name')
                     ->where($map)
                     ->order('add_time desc')
                     ->paginate();

        // dump($data_list);die;
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题','price'=>'价格'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['title', '商品标题','link',url('edit',['id'=>'__id__'])],
                ['images', '商品图片','img_url'],
                ['name', '分类名称'],
                ['price', '商品价格', 'text.edit'],
                ['status', '商品状态', 'status','',['已卖出', '上架', '下架','定时发布']],
                ['sort','排序','text.edit'],
                ['goods_num','销量', 'text.edit'],
                ['click_num','点击量', 'text.edit'],
                ['sku','库存', 'text.edit'],
                ['com_num','评论数', 'text.edit'],
                ['is_free','是否包邮',['是','否'],0],
                ['right_button', '操作', 'btn']

            ])
            ->addTopSelect('cid','分类',$fied)
            ->addFilter('price')
            ->addTopButtons('add,delete')
            ->addTopButton('enable',['status'])
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
            // $data['cid'] = implode(",",$data['cid']);
            // echo Db::table('shop_goods')->getLastSql();die;
            if (Db::name('shop_goods')->insert($data)) {
                $this->success('新增成功', 'index');
            } else {
                $this->error('新增失败');
            }
        }
        $cates = Db::name('shop_category')->where('status',1)->column('id,name');
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
                ['text', 'title', '商品名称','请输入'],
                ['select','cid', '商品分类', '请选择',$cates],
                ['select','thoughid','属性皮色','请选择',$though],
                // ['select','cationid','属性分类','请选择',$cation],
                ['select','originid','属性产地','请选择',$origin],
                ['select','rockid','属性籽料','请选择',$rock],
                // ['select','themeid','属性题材','请选择',$theme],
                ['select','kindid','属性白度','请选择',$kind],
                ['text','weight','商品重量','请输入'],
                ['text','size','商品尺寸','请输入'],
                ['number', 'price', '商品价格','请输入'],
                ['tags', 'tags', '商品标签','请输入'],
                ['tags', 'keyword', '商品关键词','请输入'],
                ['number', 'sort', '商品排序','','99'],
                ['radio', 'status', '商品状态', '', ['已卖出', '上架', '下架','定时发布'], 1],
                ['datetime','ding_time','设置定时发布时间'],
                ['radio','is_free','是否包邮','', ['是','否'], 0],
                ['number','goods_num','销量'],
                ['number','click_num','点击量'],
                ['number','sku','库存'],
                ['number','com_num','评论数'],
                ['images', 'images', '商品图片'],
                ['file','video','上传商品视频','<span class="text-danger">上传商品视频地址</span>'],
                ['ueditor','content','商品内容','<span class="text-danger">请直接上传图片就行,不要对图片进行过多操作</span>'],
//                ['radio','shopstatus', '默认为本店商品','', ['0' => '本店商品', '1' => '闲置商品', '2' => '积分商品'],0],
            ])
            ->layout([
                'cid' => 2, 
                'tid'=>2,
                'thoughid'=>2,
                'cationid'=>2,
                'originid'=>2,
                'rockid'=>2,
                'themeid'=>2,
                'kindid'=>2,
                'weight'=>2,
                'size'=>2,
                'title' => 3,
                'images'=>3,
                'video'=>4,
                'price' => 2,
                'tags' => 3,
                'keyword'=>3,
                'status'=>4,
                'ding_time'=>2,
                'goods_num'=>1,
                'click_num'=>1,
                'sku'=>1,
                'com_num'=>1,
                'is_free'=>2,
                'sort' => 1
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
            $data['add_time'] = time();
            // $data['cid'] = implode(",",$data['cid']);
            if ($advert = Db::name('shop_goods')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $cate = Db::name('shop_category')->where('status',1)->column('id,name');
        $though = Db::name('shop_though')->where('status',1)->column('id,name');
        // $cation = Db::name('shop_cation')->column('id,name');
        $kind = Db::name('shop_kind')->where('status',1)->column('id,name');
        // $theme = Db::name('shop_theme')->column('id,name');
        $origin = Db::name('shop_origin')->where('status',1)->column('id,name');
        $rock = Db::name('shop_rock')->where('status',1)->column('id,name');
        $info = Db::name('shop_goods')->find($id);
        // 显示编辑页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden','id'],
                ['text', 'title', '商品名称','请输入'],
                ['select','cid', '商品分类', '请选择',$cate],
                ['select','thoughid','属性皮色','请选择',$though],
                // ['select','cationid','属性分类','请选择',$cation],
                ['select','originid','属性产地','请选择',$origin],
                ['select','rockid','属性籽料','请选择',$rock],
                // ['select','themeid','属性题材','请选择',$theme],
                ['select','kindid','属性白度','请选择',$kind],
                ['text','weight','商品重量','请输入'],
                ['text','size','商品尺寸','请输入'],
                ['number', 'price', '商品价格','请输入'],
                ['images', 'images', '商品图片'],
                ['text', 'video', '编辑商品视频地址','<span class="text-danger">编辑商品视频地址</span>'],
                ['tags', 'tags', '商品标签'],
                ['tags', 'keyword', '商品关键词'],
                ['number', 'sort', '商品排序','','99'],
                ['radio', 'status', '商品状态', '', ['已卖出', '上架', '下架','定时发布']],
                ['datetime','ding_time','设置定时发布时间'],
                ['number','goods_num','销量'],
                ['number','click_num','点击量'],
                ['number','sku','库存'],
                ['number','com_num','评论数'],
                ['radio','is_free','是否包邮','', ['是','否'], 0],
                ['ueditor','content','商品内容','<span class="text-danger">请直接上传图片就行,不要对图片进行过多操作</span>']
            ])
            ->setFormData($info)
            ->layout([
                'cid'=>2,
                'tid'=>2,
                'thoughid'=>2,
                'cationid'=>2,
                'originid'=>2,
                'rockid'=>2,
                'themeid'=>2,
                'kindid'=>2,
                'weight'=>2,
                'size'=>2,
                'title' => 3, 
                'price' => 2, 
                'tags' => 3,
                'keyword'=>3,
                'goods_num'=>1,
                'click_num'=>1,
                'status'=>4,
                'ding_time'=>2,
                'sku'=>1,
                'comment_num'=>1,
                'com_num'=>1,
                'is_free'=>2,
                'sort' => 1
                ])
            ->fetch();

    }

}