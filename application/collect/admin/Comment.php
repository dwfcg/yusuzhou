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

 * 评论控制器

 * @package app\cms\admin

 */

class Comment extends Admin

{
    public function index(){
        $map = $this->getMap();
        $data_list = Db::name('shop_comment')->alias('a')

            ->join("user b","a.uid=b.id")

            ->join("collect_good c","a.collect_id=c.id")

            ->field("a.*,b.name,b.headimg,c.title")

            ->where($map)
            ->where('goodsstatus',1)
            ->order('add_time desc')->paginate();
        return ZBuilder::make('table')
            ->setTableName('shop_comment')
            ->setSearch(['a.content'=>'内容','b.name'=>'姓名'])
            ->addColumns([
                ['id','ID'],
                ['title','商品标题'],
                ['name','评论人'],
                ['headimg','评论人头像','img_url'],
                ['content','评论内容','text'],
                ['images','评论图片','img_url'],
                ['status','评论状态','switch'],
                ['right_button','操作','btn']
            ])
            ->addTopButtons('delete')
            ->addRightButtons(['edit','delete'=>['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch();
    }
    public function edit($id='')
    {
        if($this->request->isPost())
        {
            $data = $this->request->post();
            $update=['status'=>$data['status']];
            $advert1 = Db::name('shop_comment')->where('id',$data['id'])->update($update);
            if ($advert1) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $data_list = Db::name('shop_comment')->alias('a')
            ->join("user b","a.uid=b.id")
            ->join("shop_goods c","a.goods_id=c.id")
            ->field("a.*,b.name,b.headimg,c.title")
            ->find($id);
//        dump($data_list);
        $data_list['images']=array_filter(explode(',',$data_list['images']));
        $html='';
        foreach ($data_list['images'] as $k =>$v)
        {
            $html=$html.'<img  src="'.$data_list["images"][$k].'" height="150" width="150" />';
        }
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden','id'],
                ['static','content', '评价描述'],
//                ['image','images', '订单编号'],
//                ['text','comment', '商品描述'],
//                ['images', 'images', '商品图片'],
                ['radio','status', '','', [ '0' => '失效','1' => '有效'],1],
            ])
            ->setExtraHtml($html, 'form_top')
            ->setFormData($data_list)
            ->fetch();
    }
}
