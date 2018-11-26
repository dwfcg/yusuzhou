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
* 仓库管理
*/
class Srdz extends Admin
{
	//已订制
    public function index()
	{
		$map = $this->getMap();
		//查询商品状态
		$shop = Db::name('collect_good')->where('srdz_status',1)->select();
		// var_dump($shop);
		return ZBuilder::make('table')
            ->setTableName('collect_good')
		   ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['title', '定制标题','link',url('edit',['id'=>'__id__'])],
                ['price', '定制价格','link',url('edit',['id'=>'__id__'])],
                ['srdz_status', '商品类型', 'status','',['待订制', '已订制']],
                ['right_button', '操作', 'btn']
            ])
           	->addTopButtons('delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($shop)
		    ->fetch();
	}
    //可定制
    public function keding()
    {
        $map = $this->getMap();
        //查询商品状态
        $shop = Db::name('collect_good')->where('srdz_status',0)->select();
        // var_dump($shop);
        return ZBuilder::make('table')
            ->setTableName('collect_good')
           ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['title', '定制标题','link',url('edit',['id'=>'__id__'])],
                ['price', '定制价格','link',url('edit',['id'=>'__id__'])],
                ['srdz_status', '商品类型', 'status','',['待订制', '已订制']],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($shop)
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
        $cates = Db::name('collect_category')->column('id,name');
        $though = Db::name('shop_though')->column('id,name');
        // $cation = Db::name('shop_cation')->column('id,name');
        $kind = Db::name('shop_kind')->column('id,name');
        // $theme = Db::name('shop_theme')->column('id,name');
        $origin = Db::name('shop_origin')->column('id,name');
        $rock = Db::name('shop_rock')->column('id,name');
        $info = Db::name('collect_good')->find($id);
        // 显示编辑页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden','id'],
                ['select','cid', '商品分类', '请选择',$cates],
                ['select','thoughid','属性皮色','请选择',$though],
                // ['select','cationid','属性分类','请选择',$cation],
                ['select','originid','属性产地','请选择',$origin],
                ['select','rockid','属性籽料','请选择',$rock],
                // ['select','themeid','属性题材','请选择',$theme],
                ['select','kindid','属性白度','请选择',$kind],
                ['text','weight','订制重量','请输入'],
                ['text','size','订制尺寸','请输入'],
                ['text', 'title', '订制名称','请输入'],
                ['number', 'price', '订制价格','请输入'],
                ['images', 'images', '订制图片'],
                ['text', 'video', '上传订制视频地址'],
                ['tags', 'tags', '订制标签','请输入'],
                ['number', 'sort', '订制排序','','99'],
                ['radio', 'srdz_status', '订制状态', '', ['待订制','已订制']],
                ['number','good_num','销量'],
                ['number','good_click','点击量'],
                // ['number','sku','库存'],
                ['number','good_com','评论数'],
                ['radio','is_free','是否包邮','', ['是','否'], 0],
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
                'video'=>5,
                'size'=>2,
                'title' => 3, 
                'price' => 2, 
                'tags' => 3,
                'good_num'=>3,
                'good_click'=>3,
                'sku'=>3,
                'good_com'=>3,
                'is_free'=>3,
                'sort' => 2
                ])
            ->fetch();

    }
}
