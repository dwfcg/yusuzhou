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
 * 仓库管理
 */
class Ustore extends Admin
{
    //下架
    public function index()
    {
        $map = $this->getMap();
        $map['status']=array('eq',2);
        // $fied = Db::name('shop_category')->where('status',1)->column('id,name');
        $data_list = Db::name('shop_goods')->alias('a')
//            ->join('shop_category b','a.cid = b.id')
            ->where(['a.status'=>$map['status']])
            ->where('shopstatus',1)
//            ->field('a.*,b.name')
            ->order('add_time desc')
            ->paginate();
        // var_dump($data_list);die;
        return ZBuilder::make('table')
            ->setTableName('shop_goods')
            ->addColumns([
                // 批量添加数据列
                ['id', 'ID'],
                ['title', '商品标题','link',url('edit',['id'=>'__id__'])],
                ['images', '商品图片','img_url'],
//                ['name', '分类名称'],
                ['price', '商品价格','link',url('edit',['id'=>'__id__'])],
                ['status', '商品类型', 'status','',['已结缘','上架', '下架','定时发布']],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch();
    }
    //已结缘
    public function stocks(){
        $map = $this->getMap();
        $map['status'] = array('eq',0);
        // $fied = Db::name('shop_category')->where('status',1)->column('id,name');
        // $count = Db::name('shop_goods')->where('status',1)->count();
        $data_list = Db::name('shop_goods')->alias('a')
//            ->join('shop_category b','a.cid = b.id')
            ->where(['a.status'=>$map['status']])
            ->where('shopstatus',1)
//            ->field('a.*,b.name')
            ->order('add_time desc')
            ->paginate();
        return ZBuilder::make('table')
            ->setTableName('shop_goods')
            ->addColumns([
                // 批量添加数据列
                ['id', 'ID','link',url('dign',['id'=>'__id__'])],
                ['title', '商品标题','link',url('edit',['id'=>'__id__'])],
                ['images', '商品图片','img_url'],
//                ['name', '分类名称'],
                ['price', '商品价格','link',url('edit',['id'=>'__id__'])],
                ['status', '商品类型', 'status','',['已结缘','上架', '下架','定时发布']],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch();
    }
    //上架
    public function sale(){
        $map = $this->getMap();
        $map['status'] = array('eq',1);
        // $fied = Db::name('shop_category')->where('status',1)->column('id,name');
        // $count = Db::name('shop_goods')->where('status',1)->count();
        $data_list = Db::name('shop_goods')->alias('a')
//            ->join('shop_category b','a.cid = b.id')
            ->where('shopstatus',1)
            ->where(['a.status'=>$map['status']])
//            ->field('a.*,b.name')
            ->order('add_time desc')
            ->paginate();
        return ZBuilder::make('table')
            ->setTableName('shop_goods')
            ->addColumns([
                // 批量添加数据列
                ['id', 'ID'],
                ['title', '商品标题','link',url('edit',['id'=>'__id__'])],
                ['images', '商品图片','img_url'],
//                ['name', '分类名称'],
                ['price', '商品价格','link',url('edit',['id'=>'__id__'])],
                ['status', '商品类型', 'status','',['已结缘','上架', '下架','定时发布']],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch();
    }
//    //闲置
//    public function unuse(){
//        $map = $this->getMap();
//        $data_list = Db::name('shop_unuse')
//            ->paginate();
//        return ZBuilder::make('table')
//            ->addColumns([
//                // 批量添加数据列
//                ['id', 'ID'],
//                ['title', '商品标题','link',url('edit',['id'=>'__id__'])],
//                ['images', '商品图片','img_url'],
//                ['name', '分类名称'],
//                ['price', '商品价格','link',url('edit',['id'=>'__id__'])],
//                ['status', '商品类型', 'status','',['已结缘','上架', '下架','定时发布']],
//                ['right_button', '操作', 'btn']
//            ])
//            ->addTopButtons('delete',['table'=>'shop_goods'])
//            ->addTopButtons('enable',['status'])
//            ->addTopButtons('disable',['status'])
//            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。','table'=>'shop_goods']])
//            ->setRowList($data_list)
//            ->fetch();
//    }
    //定时发布
    public function timing(){
        $map = $this->getMap();
        $map['status'] = array('eq',3);
        $data_list = Db::name('shop_goods')->alias('a')
//            ->join('shop_category b','a.cid = b.id')
            ->where(['a.status'=>$map['status']])
            ->where('shopstatus',1)
//            ->field('a.*,b.name')
            ->order('add_time desc')
            ->paginate();
        return ZBuilder::make('table')
            ->setTableName('shop_goods')
            ->addColumns([
                // 批量添加数据列
                ['id', 'ID','link',url('Store/dign',['id'=>'__id__'])],
                ['title', '商品标题','link',url('edit',['id'=>'__id__'])],
                ['images', '商品图片','img_url'],
//                ['name', '分类名称'],
                ['price', '商品价格','link',url('edit',['id'=>'__id__'])],
                ['status', '商品类型', 'status','',['已结缘','上架','下架','定时发布']],
                // ['ding_time','定时发布时间','datetime'],
                ['right_button', '操作', 'btn']
            ])
            // ->raw('ding_time')
            ->addTopButtons('delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch();
    }
    //
    public function dign($id=null)
    {
        if ($id === null) $this->error('缺少参数');
        $time['time'] = date("Y-m-d H:i");
        $shop = Db::name('shop_goods')->where(['id'=>$id])->find();
        // $shop['ding_time'] = date("Y-m-d H:i");
        // var_dump($time['time']);
        // var_dump($shop['ding_time']);die;
        if ($shop['ding_time'] == $time['time']) {
            $shop = Db::name('shop_goods')->where(['id'=>$id])->update(['status'=>1]);
            $this->success('已发布', 'index');
        }else{
            $this->error('即将发布');
        }
    }
    /**
     * 编辑
     * @param null $id 广告id
     * @author Lieber
     * @return mixed
     */
    public function setCat($ca,$res)
    {
        foreach ($ca as $k =>$v)
        {
            $cate[]=[
                'shopgoods_id'=>$res,
                'category_id'=>$v,
            ];
        }
        Db::name('categorygoods')->insertAll($cate);
    }
    public function edit($id = null)
    {
        if ($id === null) $this->error('缺少参数');
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            $data['add_time'] = time();
            // $data['cid'] = implode(",",$data['cid']);
            Db::name('categorygoods')->where('shopgoods_id',$id)->delete();
            $this->setCat($data['s'],$id);
            if ($advert = Db::name('shop_goods')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $catedata = Db::name('categorygoods')->where('shopgoods_id',$id)->column('category_id');
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
                ['select','s','商品分类','请选择',$cate,$catedata,'multiple'],
//                ['select','cid', '商品分类', '请选择',$cate],
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
                ['file', 'video'],
                ['tags', 'tags', '商品标签'],
                ['tags', 'keyword', '商品关键词'],
                ['number', 'sort', '商品排序','','99'],
                ['radio', 'status', '商品状态', '', ['已卖出', '上架', '下架']],
//                ['datetime','ding_time','设置定时发布时间'],
//                ['number','goods_num','销量'],
//                ['number','click_num','点击量'],
//                ['number','sku','库存'],
//                ['number','com_num','评论数'],
                ['radio','is_free','是否包邮','', ['是','否'], 0],
                ['radio','recommend','是否推荐','', ['是','否'], 1],
                ['ueditor','content','商品内容','<span class="text-danger">请直接上传图片就行,不要对图片进行过多操作</span>']
            ])
            ->setFormData($info)
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
//                'title' => 5,
//                'images'=>3,
//                'video'=>3,
                'price' => 2,
                'tags' => 2,
                'keyword'=>2,
//                'status'=>4,
//                'is_free'=>2,
                'sort' => 2,
                'content' =>12
            ])
            ->fetch();

    }
}
