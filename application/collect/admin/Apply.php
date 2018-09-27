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

class Apply extends Admin

{

    /**

     * 私人订制shenqing列表

     * @author Lieber

     * @return mixed

     */

    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 数据列表
        $data_list = Db::name('collect_apply')->alias('a')
                     ->join('user c','a.uid=c.id')
                     ->field('a.*,c.name as cname,c.headimg')
                     ->where($map)
                     ->order('add_time desc')
                     ->paginate();

        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['username','用户真实姓名'],
                ['cname', '申请人'],
                ['headimg', '申请人头像','img_url'],
                ['phone','用户手机号'],
                ['content','需求'],
                ['price_yu', '预算价格'],
                ['province','地址'],
                ['address','详细地址'],
                ['images','申请图片', 'img_url'],
                ['beizhu','用户备注'],
                ['status', '申请状态', 'status','',['定制中', '定制完成']],
                ['add_time','申请时间','datetime'],
                ['right_button', '操作', 'btn']

            ])
            ->addTopButtons('add,enable,disable,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板

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
            if ($advert = Db::name('collect_apply')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }

        $info = Db::name('collect_apply')->find($id);
        // 显示编辑页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden','id'],
                ['text','username','用户真实姓名'],
                ['text', 'phone', '该用户手机号'],
                ['text','province', '用户地址'],
                ['text','address', '详细地址'],
                ['ueditor','content','订制简介'],
                ['number', 'price_yu', '价格预算'],
                ['images', 'images', '订制图片'],
                ['text','beizhu','用户备注'],
                ['radio', 'status', '申请状态','',['定制中','定制完成'],0]
            ])
            ->setFormData($info)
            ->layout([
                'username'=>3,
                'phone'=>3,
                'price_yu'=>3,
                'province'=>3,
                'address'=>3
                ])
            ->fetch();

    }

}