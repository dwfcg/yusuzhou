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

namespace app\user\admin;

use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use app\user\model\Member as MemberModel;
use util\Tree;
use think\Db;
use think\Hook;

/**
 * 用户默认控制器
 * @package app\user\admin
 */
class Member extends Admin
{
    /**
     * 用户首页
     * @return mixed
     */
    public function index()
    {
        cookie('__forward__', $_SERVER['REQUEST_URI']);

        // 获取查询条件
        $map = $this->getMap();
        $data=Db::name('user_ship')->order('level asc')->select();
        $data1=[];
        $i=1;
        foreach ($data as $k=>$v)
        {
            $data1[$i++]=$v['name'];
        }
        // 数据列表
        $data_list = Db::name('user')->alias('a')
            ->join("user_ship b","a.level=b.level")
            ->order('add_time,id desc')
            ->field('a.*,b.name as title')
            ->paginate();
// dump($data_list);exit;
        // 分页数据
        $page = $data_list->render();

        // 授权按钮
        $btn_access = [
            'title' => '授权',
            'icon'  => 'fa fa-fw fa-key',
            'href'  => url('access', ['uid' => '__id__'])
        ];

        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setPageTitle('会员管理') // 设置页面标题
            ->setTableName('user') // 设置数据表名
            ->setSearch(['id' => 'ID', 'name' => '会员名', 'mobile' => '手机号']) // 设置搜索参数
            ->addColumns([ // 批量添加列
                ['id', 'ID','link',url('edit',['id'=>'__id__'])],
                ['name', '用户名', 'text.edit'],
                ['level', '会员等级','status','',$data1],
                ['sex', '性别','status','',[1=>'男','女']],
                ['openid', 'openid'],
                ['headimg', '头像','img_url'],
                ['mobile', '手机号'],
                ['guanzhu', '关注'],
                ['fensi', '粉丝数'],
                ['zan', '点赞数'],
                ['shoucang', '收藏数'],
                ['fabu', '发布数'],
                ['shoucang', '收藏数'],
                ['huozan', '获赞数'],
                ['daren', '状态','status','',['否','是','待审核']],
                ['status', '状态','status','',[0=>'已禁用','正常']],
                ['add_time', '注册时间', 'datetime'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('enable,disable,delete') // 批量添加顶部按钮
            // ->addRightButton('custom', $btn_access) // 添加授权按钮
            // ->addRightButtons('edit,delete') // 批量添加右侧按钮
            ->addRightButtons(['edit','delete'=>['data-tips' => '删除后无法恢复。']]) // 批量添加右侧按钮
            ->setRowList($data_list) // 设置表格数据
            ->setPages($page) // 设置分页数据
            ->fetch(); // 渲染页面
    }
    //编辑
     public function edit($id = null){
        if ($id == null) $this->error('缺少参数');
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if ($us = DB::name('user')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('user')->find($id);
        return ZBuilder::make('form')
            ->addFormItems([
                    ['hidden','id'],
                    ['text','name','姓名'],
                    ['image', 'headimg', '头像'],
                    ['radio','status', '状态','',['已禁用','正常']]
                ])
            ->setFormData($info)
            ->layout(['name'=>2])
            ->fetch();
    }


    /**
     * 新增
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    // public function add()
    // {
    //     // 保存数据
    //     if ($this->request->isPost()) {
    //         $data = $this->request->post();
    //         // 验证
    //         $result = $this->validate($data, 'Member');
    //         // 验证失败 输出错误信息
    //         if(true !== $result) $this->error($result);

    //         if ($user = UserModel::create($data)) {
    //             Hook::listen('user_add', $user);
    //             // 记录行为
    //             action_log('user_add', 'admin_user', $user['id'], UID);
    //             $this->success('新增成功', url('index'));
    //         } else {
    //             $this->error('新增失败');
    //         }
    //     }

    //     // 使用ZBuilder快速创建表单
    //     return ZBuilder::make('form')
    //         ->setPageTitle('新增') // 设置页面标题
    //         ->addFormItems([ // 批量添加表单项
    //             ['text', 'username', '用户名', '必填，可由英文字母、数字组成'],
    //             ['text', 'nickname', '昵称', '可以是中文'],
    //             ['select', 'role', '角色', '', RoleModel::getTree(null, false)],
    //             ['text', 'email', '邮箱', ''],
    //             ['password', 'password', '密码', '必填，6-20位'],
    //             ['text', 'mobile', '手机号'],
    //             ['image', 'avatar', '头像'],
    //             ['radio', 'status', '状态', '', ['禁用', '启用'], 1]
    //         ])
    //         ->fetch();
    // }

    /**
     * 编辑
     * @param null $id 用户id
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    // public function edit($id = null)
    // {
    //     if ($id === null) $this->error('缺少参数');

    //     // 保存数据
    //     if ($this->request->isPost()) {
    //         $data = $this->request->post();

    //         // 禁止修改超级管理员的角色和状态
    //         if ($data['id'] == 1 && $data['role'] != 1) {
    //             $this->error('禁止修改超级管理员角色');
    //         }

    //         // 禁止修改超级管理员的状态
    //         if ($data['id'] == 1 && $data['status'] != 1) {
    //             $this->error('禁止修改超级管理员状态');
    //         }

    //         // 验证
    //         $result = $this->validate($data, 'User.update');
    //         // 验证失败 输出错误信息
    //         if(true !== $result) $this->error($result);

    //         // 如果没有填写密码，则不更新密码
    //         if ($data['password'] == '') {
    //             unset($data['password']);
    //         }

    //         if (UserModel::update($data)) {
    //             $user = UserModel::get($data['id']);
    //             Hook::listen('user_edit', $user);
    //             // 记录行为
    //             action_log('user_edit', 'admin_user', $user['id'], UID, get_nickname($user['id']));
    //             $this->success('编辑成功', cookie('__forward__'));
    //         } else {
    //             $this->error('编辑失败');
    //         }
    //     }

    //     // 获取数据
    //     $info = UserModel::where('id', $id)->field('password', true)->find();

    //     // 使用ZBuilder快速创建表单
    //     return ZBuilder::make('form')
    //         ->setPageTitle('编辑') // 设置页面标题
    //         ->addFormItems([ // 批量添加表单项
    //             ['hidden', 'id'],
    //             ['static', 'username', '用户名', '不可更改'],
    //             ['text', 'nickname', '昵称', '可以是中文'],
    //             ['select', 'role', '角色', '', RoleModel::getTree(null, false)],
    //             ['text', 'email', '邮箱', ''],
    //             ['password', 'password', '密码', '必填，6-20位'],
    //             ['text', 'mobile', '手机号'],
    //             ['image', 'avatar', '头像'],
    //             ['radio', 'status', '状态', '', ['禁用', '启用']]
    //         ])
    //         ->setFormData($info) // 设置表单数据
    //         ->fetch();
    // }


}
