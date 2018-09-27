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

 * 拍卖记录

 * @package app\cms\admin

 */

class Record extends Admin
{
    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 数据列表
        // $data_list = Db::name('auction_goods')->where($map)->order('addtime desc')->paginate();
        $data_list = Db::name('auction_record')->alias('r')
                    ->join('auction_goods g','r.goodid=g.id')
                    ->join('user u','r.userid=u.id')
                    ->where($map)
                    ->field('r.money,r.datetime,r.states,r.success,g.id,g.title,g.imgs,u.id,u.name,u.headimg')
                    ->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['title', '商品名称', 'text.edit'],
                ['imgs','商品图片','img_url'],
                ['name','出价人'],
                ['headimg','用户头像'],
                ['money','出价金额'],
                ['datetime','出价时间','datetime'],
                ['states', '是否付款', 'status','',['未支付', '已支付']],
                ['success','是否成功拍到','status',['成功','失败']],
                ['right_button', '操作', 'btn']
            ])
            ->addRightButton('delete',['data-tips' => '删除后无法恢复。'])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }

}
