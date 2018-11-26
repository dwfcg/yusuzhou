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

namespace app\auction\admin;

use think\Db;

use app\admin\controller\Admin;

use app\common\builder\ZBuilder;

/**

 * 拍卖

 * @package app\cms\admin

 */

class Pai extends Admin
{
    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 数据列表
        $data_list = Db::name('auction_goods')->where($map)->order('addtime desc')->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setTableName('auction_goods')
            ->setSearch(['title' => '标题']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['title', '商品名称', 'text.edit'],
                ['imgs','商品图片','img_url'],
                ['start_price','起拍价'],
                ['price','当前价格'],
                ['price_range','加价幅度'],
                ['bands','保证金金额'],
                ['start_time','开始时间','text'],
                ['end_time','结束时间','text'],
                ['status', '状态', 'status','',['即将开始', '进行中','流拍','已结束']],
                ['partake','浏览人数','text.edit'],
                ['offer','出价人数'],
                ['addtime', '创建时间', 'datetime'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('add,enable,disable,delete')
            ->addRightButton('edit')
            ->addRightButton('delete',['data-tips' => '删除后无法恢复。'])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    /**
     * 拍卖新增
     * @author Zain
     * @return mixed
     */
    public function add()
    {
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            $data['addtime'] = time();
            $advert = Db::name('auction_goods')->insert($data);
            if ($advert) {
                $this->success('新增成功', 'index');
            } else {
                $this->error('新增失败');
            }
        }
        //$info = Db::name('auction_goods')->find($id);
        // 显示添加页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden','id'],
                ['text', 'title', '商品名称'],
                ['tags', 'tags', '商品标签'],
                ['text','partake','浏览人数'],
                ['text','bands','保证金金额'],
                ['images', 'imgs', '商品图片'],
                // ['textarea', 'attrs', '属性','设置规则：属性=值，例：产状=籽料，  一行一个'],
                ['text', 'start_price', '起拍价'],
                ['text', 'price', '当前价'],
                ['text', 'price_range', '价格幅度'],
                ['ueditor', 'content', '详情'],
                ['datetime','start_time','开始时间'],
                ['datetime','end_time','结束时间'],
                ['radio', 'status', '状态', '', ['即将开始', '进行中','流拍','已结束'], 1]
            ])
            //->setFormData($info)
            ->layout(['title' => 2, 'tags' => 4, 'attrs' => 4, 'start_price' => 3, 'price' => 3, 'price_range' => 3, 'start_time' => 2, 'end_time' => 2,'partake'=>2,'bands'=>2])
            ->fetch();
    }
    //修改
    public function edit($id = null)
    {
        if ($id === null) $this->error('缺少参数');
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            if ($advert = Db::name('auction_goods')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('auction_goods')->find($id);
        // 显示添加页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden','id'],
                ['text', 'title', '商品名称'],
                ['tags', 'tags', '商品标签'],
                ['text','partake','浏览人数'],
                ['text','bands','保证金金额'],
                ['images', 'imgs', '商品图片'],
                // ['textarea', 'attrs', '属性','设置规则：属性=值，例：产状=籽料，  一行一个'],
                ['text', 'start_price', '起拍价'],
                ['text', 'price', '当前价'],
                ['text', 'price_range', '价格幅度'],
                ['ueditor', 'content', '详情'],
                ['datetime','start_time','开始时间'],
                ['datetime','end_time','结束时间'],
                ['radio', 'status', '状态', '', ['即将开始', '进行中','流拍','已结束']]
            ])
            ->setFormData($info)
            ->layout(['title' => 2, 'tags' => 4, 'attrs' => 4, 'start_price' => 3, 'price' => 3, 'price_range' => 3, 'start_time' => 2, 'end_time' => 2,'partake'=>2,'bands'=>2])
            ->fetch();
    }
}
