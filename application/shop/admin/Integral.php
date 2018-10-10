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
 * 仓库积分商品管理
 */
class Integral extends Admin
{
    //积分商品
    public function integral(){
        $map = $this->getMap();
        $map['shopstatus'] = array('eq',2);
        // $fied = Db::name('shop_category')->where('status',1)->column('id,name');
        // $count = Db::name('shop_goods')->where('status',1)->count();
        $data_list = Db::name('shop_goods')->alias('a')
            ->join('shop_category b','a.cid = b.id')
            ->where(['a.shopstatus'=>$map['shopstatus']])
            ->field('a.*,b.name')
            ->order('add_time desc')
            ->paginate();
        return ZBuilder::make('table')
            ->addColumns([
                // 批量添加数据列
                ['id', 'ID'],
                ['title', '商品标题','link',url('edit',['id'=>'__id__'])],
                ['images', '商品图片','img_url'],
                ['name', '分类名称'],
                ['price', '商品价格','link',url('edit',['id'=>'__id__'])],
                ['status', '商品类型', 'status','',['已结缘','上架', '下架','定时发布']],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('delete',['table'=>'shop_goods'])
            ->addTopButtons('enable',['status'])
            ->addTopButtons('disable',['status'])
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。','table'=>'shop_goods']])
            ->setRowList($data_list)
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
            $data['cid'] = implode(",",$data['cid']);
            if ($advert = Db::name('shop_goods')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功','integral');
            } else {
                $this->error('编辑失败');
            }
        }
        $cate = Db::name('shop_category')->column('id,name');
        $though = Db::name('shop_though')->column('id,name');
        $cation = Db::name('shop_cation')->column('id,name');
        $kind = Db::name('shop_kind')->column('id,name');
        $theme = Db::name('shop_theme')->column('id,name');
        $origin = Db::name('shop_origin')->column('id,name');
        $rock = Db::name('shop_rock')->column('id,name');
        $info = Db::name('shop_goods')->find($id);
        // 显示编辑页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden','id'],
                ['select','cid', '商品分类', '请选择',$cate,'','multiple'],
                ['select','thoughid','属性皮色','请选择',$though],
                ['select','cationid','属性分类','请选择',$cation],
                ['select','originid','属性产地','请选择',$origin],
                ['select','rockid','属性产状','请选择',$rock],
                ['select','themeid','属性题材','请选择',$theme],
                ['select','kindid','属性种类','请选择',$kind],
                ['text','weight','商品重量'],
                ['text','size','商品尺寸'],
                ['text', 'title', '商品名称'],
                ['number', 'price', '商品价格'],
                ['images', 'images', '商品图片'],
                ['text', 'video', '编辑商品视频地址','<span class="text-danger">编辑商品视频地址</span>'],
                ['tags', 'tags', '商品标签'],
                ['number', 'sort', '商品排序','','99'],
                ['radio', 'status', '商品状态', '', ['已卖出', '上架', '下架','定时发布']],
                ['datetime','ding_time','设置定时发布时间', '', 'Y-m-d H:i:s'],
                ['number','goods_num','销量'],
                ['number','click_num','点击量'],
                ['number','sku','库存'],
                ['number','com_num','评论数'],
                ['radio','is_free','是否包邮','', ['是','否'], 0],
                ['ueditor','content','商品内容'],
                ['radio','shopstatus', '默认为本店商品','', ['0' => '本店商品', '1' => '闲置商品', '2' => '积分商品'],0],
            ])
            ->setFormData($info)
            ->layout([
                'cid'=>3,
                'tid'=>3,
                'thoughid'=>3,
                'cationid'=>3,
                'originid'=>3,
                'rockid'=>3,
                'themeid'=>3,
                'kindid'=>3,
                'weight'=>2,
                'size'=>3,
                'video'=>5,
                'ding_time'=>2,
                'title' => 3,
                'price' => 2,
                'tags' => 3,
                'goods_num'=>3,
                'click_num'=>3,
                'sku'=>3,
                'comment_num'=>3,
                'com_num'=>3,
                'is_free'=>3,
                'sort' => 2
            ])
            ->fetch();

    }
}
