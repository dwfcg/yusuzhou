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



namespace app\forum\admin;

use think\Db;

use app\admin\controller\Admin;

use app\common\builder\ZBuilder;

/**
 * 帖子控制器
 * @package app\cms\admin
 */
class Thread extends Admin
{
    /**
     * 帖子列表
     * @author Lieber
     * @return mixed
     */
    public function index()
    {
        // 查询
        $map = $this->getMap();
//        $map['sid'] = array('neq',4);
        // 数据列表
        $section = Db::name('forum_section')->column('id,tionname');
        $data_list = Db::name('forum_thread')->alias('a')
                    ->join("user b","a.uid=b.id")
                    ->join('forum_section s','a.sid=s.id')
                    ->field("a.*,b.name,b.headimg,s.tionname")
                    ->where($map)->order('add_time desc')->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题','name' => '发帖人'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID','link',url('thread/fuwen',['id'=>'__id__'])],
                ['title', '帖子标题','link',url('edit',['id'=>'__id__'])],
                ['tionname','帖子板块'],
                ['name', '发帖人'],
                ['headimg', '发帖人头像','img_url'],
                ['view_num', '浏览人数', 'text.edit'],
                ['zan_num', '点赞次数', 'text.edit'],
                ['type','帖子类型','status','',['图片','文章','视频']],
                ['status', '帖子状态', 'switch'],
                // ['is_home', '是否显示', 'switch'],
                ['flag','是否置顶','switch'],
                ['stick','是否加精','switch'],
                ['add_time','发帖时间','datetime'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopSelect('sid','版块',$section)
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    //帖子访问路径
    public function tieurl()
    {
        $map = $this->getMap();
        $data_list = Db::name('forum_thread')
                    ->where($map)->order('add_time desc')
                    ->paginate();
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['title', '帖子标题'],
                ['url','访问路径'],
                ['add_time','发帖时间','datetime']
            ])
            ->setRowList($data_list)
            ->fetch();
    }
    //截取内容图片
    public function fuwen($id = null){
        if ($id === null) $this->error('缺少参数');
        // dump($id);
        $nke = Db::name('forum_thread')->where('id',$id)->find();
        $content = $nke['content'];
        preg_match_all('#src="([^"]+?)"#',$content, $the );
        $sd = implode(',',$the[1]);
        $na = Db::name('forum_thread')->where('id',$id)->update(['conimage'=>$sd]);
        if ($na = 1) {
            $this->success('编辑成功', 'index');
        } else {
            $this->error('编辑失败');
        }
    }
    //管理员上传的帖子
    public function guan()
    {
        $map = $this->getMap();
        $map['uid'] = '7';
        // 数据列表
        $data_list = Db::name('forum_thread')->alias('a')
                    ->join("user b","a.uid=b.id")
                    ->join('forum_cate s','a.cid=s.id')
                    ->field("a.*,b.name,b.headimg,s.name as sname")
                    ->where($map)->order('add_time desc')->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题','name' => '发帖人'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID','link',url('edit',['id'=>'__id__'])],
                ['title', '帖子标题','link',url('edit',['id'=>'__id__'])],
                ['sname','帖子分类'],
                ['name', '发帖人'],
                ['headimg', '发帖人头像','img_url'],
                ['view_num', '浏览人数', 'text.edit'],
                ['zan_num', '点赞次数', 'text.edit'],
                ['type','帖子类型','status','',['图片','文章','视频']],
                ['status', '帖子状态', 'switch'],
                // ['is_home', '是否显示', 'switch'],
                ['flag','是否置顶','switch'],
                ['stick','是否加精','switch'],
                ['add_time','发帖时间','datetime'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    //热帖文章
    public function retie(){
        $map = $this->getMap();
        $map["sid"] = array('neq',4);
        $map["zan_num"] = array('egt',100);
        $map['view_num'] = array('egt',100);
        $data_list = Db::name('forum_thread')->alias('a')
                    ->join("user b","a.uid=b.id")
                    ->join('forum_section s','a.sid=s.id')
                    ->field("a.*,b.name,b.headimg,s.tionname")
                    ->where($map)
                    ->order('add_time desc')->paginate();
        // dump($data_list);die;
        $section = Db::name('forum_section')->column('id,tionname');
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题','name' => '发帖人'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['title', '帖子标题','link',url('edit',['id'=>'__id__'])],
                ['tionname','帖子板块'],
                ['name', '发帖人'],
                ['headimg', '发帖人头像','img_url'],
                ['view_num', '浏览人数', 'text.edit'],
                ['zan_num', '点赞次数', 'text.edit'],
                ['type','帖子类型','status','',['图片','文章','视频']],
                ['status', '帖子状态', 'switch'],
                // ['is_home', '是否显示', 'switch'],
                ['flag','是否置顶','switch'],
                ['stick','是否加精','switch'],
                ['add_time','发帖时间','datetime'],
                ['right_button', '操作', 'btn']

            ])
            ->addTopSelect('sid','版块',$section)
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    //店主帖子板块
    public function diantie()
    {
        // 查询
        $map = $this->getMap();
        $map['sid'] = '6';
        // 数据列表
        $section = Db::name('forum_section')->column('id,tionname');
        $data_list = Db::name('forum_thread')->alias('a')
                    ->join("user b","a.uid=b.id")
                    ->join('forum_section s','a.sid=s.id')
                    ->field("a.*,b.name,b.headimg,s.tionname")
                    ->where($map)->order('add_time desc')->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题','name' => '发帖人'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID','link',url('edit',['id'=>'__id__'])],
                ['title', '帖子标题','link',url('edit',['id'=>'__id__'])],
                ['tionname','帖子板块'],
                ['name', '发帖人'],
                ['headimg', '发帖人头像','img_url'],
                ['view_num', '浏览人数', 'text.edit'],
                ['zan_num', '点赞次数', 'text.edit'],
                ['type','帖子类型','status','',['图片','文章','视频']],
                ['status', '帖子状态', 'switch'],
                // ['is_home', '是否显示', 'switch'],
                ['flag','是否置顶','switch'],
                ['stick','是否加精','switch'],
                ['add_time','发帖时间','datetime'],
                ['right_button', '操作', 'btn']
            ])
//            ->addTopSelect('sid','版块',$section)
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    //口碑帖子
    public function maitie()
    {
        // 查询
        $map = $this->getMap();
        $map['sid'] = '8';
        // 数据列表
        $section = Db::name('forum_section')->column('id,tionname');
        $data_list = Db::name('forum_thread')->alias('a')
                    ->join("user b","a.uid=b.id")
                    ->join('forum_section s','a.sid=s.id')
                    ->field("a.*,b.name,b.headimg,s.tionname")
                    ->where($map)->order('add_time desc')->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题','name' => '发帖人'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID','link',url('edit',['id'=>'__id__'])],
                ['title', '帖子标题','link',url('edit',['id'=>'__id__'])],
                ['tionname','帖子板块'],
                ['name', '发帖人'],
                ['headimg', '发帖人头像','img_url'],
                ['view_num', '浏览人数', 'text.edit'],
                ['zan_num', '点赞次数', 'text.edit'],
                ['type','帖子类型','status','',['图片','文章','视频']],
                ['status', '帖子状态', 'switch'],
                // ['is_home', '是否显示', 'switch'],
                ['flag','是否置顶','switch'],
                ['stick','是否加精','switch'],
                ['add_time','发帖时间','datetime'],
                ['right_button', '操作', 'btn']
            ])
//            ->addTopSelect('sid','版块',$section)
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    //视频帖子
    public function shitie()
    {
        // 查询
        $map = $this->getMap();
        $map['sid'] = '4';
        // 数据列表
        $section = Db::name('forum_section')->column('id,tionname');
        $data_list = Db::name('forum_thread')->alias('a')
                    ->join("user b","a.uid=b.id")
                    ->join('forum_section s','a.sid=s.id')
                    ->field("a.*,b.name,b.headimg,s.tionname")
                    ->where($map)->order('add_time desc')->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题','name' => '发帖人'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID','link',url('edit',['id'=>'__id__'])],
                ['title', '帖子标题','link',url('edit',['id'=>'__id__'])],
                ['tionname','帖子板块'],
                ['name', '发帖人'],
                ['headimg', '发帖人头像','img_url'],
                ['view_num', '浏览人数', 'text.edit'],
                ['zan_num', '点赞次数', 'text.edit'],
                ['type','帖子类型','status','',['图片','文章','视频']],
                ['status', '帖子状态', 'switch'],
                ['add_time','发帖时间','datetime'],
                ['right_button', '操作', 'btn']
            ])
//            ->addTopSelect('sid','版块',$section)
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    //知识帖子
    public function zhitie()
    {
        // 查询
        $map = $this->getMap();
        $map['sid'] = '3';
        // 数据列表
        $section = Db::name('forum_section')->column('id,tionname');
        $data_list = Db::name('forum_thread')->alias('a')
                    ->join("user b","a.uid=b.id")
                    ->join('forum_section s','a.sid=s.id')
                    ->field("a.*,b.name,b.headimg,s.tionname")
                    ->where($map)->order('add_time desc')->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题','name' => '发帖人'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID','link',url('edit',['id'=>'__id__'])],
                ['title', '帖子标题','link',url('edit',['id'=>'__id__'])],
                ['tionname','帖子板块'],
                ['name', '发帖人'],
                ['headimg', '发帖人头像','img_url'],
                ['view_num', '浏览人数', 'text.edit'],
                ['zan_num', '点赞次数', 'text.edit'],
                ['type','帖子类型','status','',['图片','文章','视频']],
                ['status', '帖子状态', 'switch'],
                // ['is_home', '首页推荐', 'switch'],
                ['flag','是否置顶','switch'],
                ['stick','是否加精','switch'],
                ['add_time','发帖时间','datetime'],
                ['right_button', '操作', 'btn']
            ])
//            ->addTopSelect('sid','版块',$section)
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    //苏州帖子
    public function sutie()
    {
        // 查询
        $map = $this->getMap();
        $map['sid'] = '2';
        // 数据列表
        $section = Db::name('forum_section')->column('id,tionname');
        $data_list = Db::name('forum_thread')->alias('a')
                    ->join("user b","a.uid=b.id")
                    ->join('forum_section s','a.sid=s.id')
                    ->field("a.*,b.name,b.headimg,s.tionname")
                    ->where($map)->order('add_time desc')->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题','name' => '发帖人'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID','link',url('edit',['id'=>'__id__'])],
                ['title', '帖子标题','link',url('edit',['id'=>'__id__'])],
                ['tionname','帖子板块'],
                ['name', '发帖人'],
                ['headimg', '发帖人头像','img_url'],
                ['view_num', '浏览人数', 'text.edit'],
                ['zan_num', '点赞次数', 'text.edit'],
                ['type','帖子类型','status','',['图片','文章','视频']],
                ['status', '帖子状态', 'switch'],
                // ['is_home', '首页推荐', 'switch'],
                ['flag','是否置顶','switch'],
                ['stick','是否加精','switch'],
                ['add_time','发帖时间','datetime'],
                ['right_button', '操作', 'btn']
            ])
//            ->addTopSelect('sid','版块',$section)
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    //社区帖子
    public function shetie()
    {
        // 查询
        $map = $this->getMap();
        $map['sid'] = '12';
        // 数据列表
        $section = Db::name('forum_section')->column('id,tionname');
        $data_list = Db::name('forum_thread')->alias('a')
                    ->join("user b","a.uid=b.id")
                    ->join('forum_section s','a.sid=s.id')
                    ->field("a.*,b.name,b.headimg,s.tionname")
                    ->where($map)->order('add_time desc')->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题','name' => '发帖人'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID','link',url('edit',['id'=>'__id__'])],
                ['title', '帖子标题','link',url('edit',['id'=>'__id__'])],
                ['tionname','帖子板块'],
                ['name', '发帖人'],
                ['headimg', '发帖人头像','img_url'],
                ['view_num', '浏览人数', 'text.edit'],
                ['zan_num', '点赞次数', 'text.edit'],
                ['type','帖子类型','status','',['图片','文章','视频']],
                ['status', '帖子状态', 'switch'],
                // ['is_home', '首页推荐', 'switch'],
                ['flag','是否置顶','switch'],
                ['stick','是否加精','switch'],
                ['add_time','发帖时间','datetime'],
                ['right_button', '操作', 'btn']
            ])
//            ->addTopSelect('sid','版块',$section)
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    //问题帖子
    public function wentie()
    {
        // 查询
        $map = $this->getMap();
        $map['sid'] = '11';
        // 数据列表
        $section = Db::name('forum_section')->column('id,tionname');
        $data_list = Db::name('forum_thread')->alias('a')
                    ->join("user b","a.uid=b.id")
                    ->join('forum_section s','a.sid=s.id')
                    ->field("a.*,b.name,b.headimg,s.tionname")
                    ->where($map)->order('add_time desc')->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题','name' => '发帖人'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID','link',url('edit',['id'=>'__id__'])],
                ['title', '帖子标题','link',url('edit',['id'=>'__id__'])],
                ['tionname','帖子板块'],
                ['name', '发帖人'],
                ['headimg', '发帖人头像','img_url'],
                ['view_num', '浏览人数', 'text.edit'],
                ['zan_num', '点赞次数', 'text.edit'],
                ['type','帖子类型','status','',['图片','文章','视频']],
                ['status', '帖子状态', 'switch'],
                // ['is_home', '首页推荐', 'switch'],
                ['flag','是否置顶','switch'],
                ['stick','是否加精','switch'],
                ['add_time','发帖时间','datetime'],
                ['right_button', '操作', 'btn']
            ])
//            ->addTopSelect('sid','版块',$section)
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    //闲置帖子
    public function xiantie()
    {
        // 查询
        $map = $this->getMap();
        $map['sid'] = '9';
        // 数据列表
        $section = Db::name('forum_section')->column('id,tionname');
        $data_list = Db::name('forum_thread')->alias('a')
                    ->join("user b","a.uid=b.id")
                    ->join('forum_section s','a.sid=s.id')
                    ->field("a.*,b.name,b.headimg,s.tionname")
                    ->where($map)->order('add_time desc')->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题','name' => '发帖人'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID','link',url('edit',['id'=>'__id__'])],
                ['title', '帖子标题','link',url('edit',['id'=>'__id__'])],
                ['tionname','帖子板块'],
                ['name', '发帖人'],
                ['headimg', '发帖人头像','img_url'],
                ['view_num', '浏览人数', 'text.edit'],
                ['zan_num', '点赞次数', 'text.edit'],
                ['type','帖子类型','status','',['图片','文章','视频']],
                ['status', '帖子状态', 'switch'],
                // ['is_home', '首页推荐', 'switch'],
                ['flag','是否置顶','switch'],
                ['stick','是否加精','switch'],
                ['add_time','发帖时间','datetime'],
                ['right_button', '操作', 'btn']
            ])
//            ->addTopSelect('sid','版块',$section)
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
    //活动帖子
    public function huotie()
    {
        // 查询
        $map = $this->getMap();
        $map['sid'] = '7';
        // 数据列表
        $section = Db::name('forum_section')->column('id,tionname');
        $data_list = Db::name('forum_thread')->alias('a')
                    ->join("user b","a.uid=b.id")
                    ->join('forum_section s','a.sid=s.id')
                    ->field("a.*,b.name,b.headimg,s.tionname")
                    ->where($map)->order('add_time desc')->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题','name' => '发帖人'], '', '', true) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID','link',url('edit',['id'=>'__id__'])],
                ['title', '帖子标题','link',url('edit',['id'=>'__id__'])],
                ['tionname','帖子板块'],
                ['name', '发帖人'],
                ['headimg', '发帖人头像','img_url'],
                ['view_num', '浏览人数', 'text.edit'],
                ['zan_num', '点赞次数', 'text.edit'],
                ['type','帖子类型','status','',['图片','文章','视频']],
                ['status', '帖子状态', 'switch'],
                // ['is_home', '首页推荐', 'switch'],
                ['flag','是否置顶','switch'],
                ['stick','是否加精','switch'],
                ['add_time','发帖时间','datetime'],
                ['right_button', '操作', 'btn']
            ])
//            ->addTopSelect('sid','版块',$section)
            ->addTopButtons('add,delete')
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
    }
//-----------------------------------------------------------------------------------------------
    //获取板块下面的分类
    public function category($id = '',$sid='')
    {
        $id = ($id)?$id:$sid;
        // $id = '6';
        $data['code'] = '1';//判断状态
        $data['msg'] = '请求成功';
        $data['list'] = Db::name('forum_cate')->field(["id"=>"key","name"=>"value"])->where('sid', $id)->select();
        return json($data);
    }
    /**
     * 添加
     * @param null $id 广告id
     * @author Lieber
     * @return mixed
     */
    public function add()
    {
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            // $data['sid'] = implode(",",$data['id']);
            $data['cid'] = $data['name'];
            $data['uid'] = '7';
            $data['add_time'] = time();
            // print_r($data);die;
            if ($result = Db::name('forum_thread')->insert($data)) {
                Db::name('user')->where(['id'=>$data['uid']])->setInc('fabu');
                $this->success('添加成功', 'index');
            } else {
                $this->error('添加失败');
            }
        }

        $section = Db::name('forum_section')->column('id,tionname');//板块
        // 显示编辑页面
        return ZBuilder::make('form')
            ->addLinkage('id','选择板块','',$section,'',url('category'),'name','id')
            ->addSelect('name','选择分类')
            ->addFormItems([
                ['hidden', 'id'],
                ['select','sid','板块','<span class="text-danger">请再次选择对应板块</span>',$section],
                // ['select','sid','版块','请选择',$section,'',url('category'),'name'],
                // ['linkages','cid','选择分类','请选择','forum_cate',2,'','id,name'],
                ['text', 'title', '帖子标题', '<span class="text-danger">必填</span>'],
                ['tags', 'keyword', '帖子关键词', '<span class="text-danger">必填</span>'],
                // ['images', 'images', '帖子图片'],
                ['file','videos','视频地址', '<span class="text-danger">仅限于视频板块,其它板块无需添加视频地址</span>'],
                ['image','firsturl','视频封面', '<span class="text-danger">仅限于视频板块,其它板块无需添加视频封面</span>'],
                ['ueditor', 'content', '帖子内容'],
                ['radio','type','帖子类型','',['图片','文章','视频'],1],
                ['radio', 'status', '帖子状态', '', ['停用', '启用'],1],
                // ['radio', 'is_home', '首页推荐', '', ['停用', '启用']],
                ['radio','flag','是否置顶','',['否','是']],
                ['radio', 'stick', '是否加精', '', ['否', '是']]
            ])
            ->layout(['sid' => 2, 'title' => 6, 'keyword' => 3])
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
            $data['cid'] = $data['name'];
            $data['add_time'] = time();
            // print_r($data);die;
            if ($advert = Db::name('forum_thread')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }
        $info = Db::name('forum_thread')->find($id);
//        $info['name'] = url('category',['id'=>$info['sid']]);
        $section = Db::name('forum_section')
//            ->where('id',$info['sid'])
            ->column('id,tionname');
        $list = Db::name('forum_cate')->where('id',$info['cid'])->column('id,name');
        // print_r($section);
        //dump($info);
//        dump($section);
        // 显示编辑页面
        return ZBuilder::make('form')
            ->addLinkage('sid','选择板块','',$section,$info['sid'],url('category'),'cid')
            ->addSelect('cid','选择分类')
//            ->addLinkage('sid','选择板块','',$section,'',url('category'),'name','id')
//            ->addSelect('name','选择分类','','',$info['cid'])
            ->addFormItems([
                ['hidden', 'id'],
                // ['select','sid','版块','请选择',$section],
                ['text', 'title', '帖子标题'],
                ['tags', 'keyword', '帖子关键词'],
                ['text','videos','视频地址', '<span class="text-danger">仅限于视频板块,其它板块无需添加视频地址</span>'],
                ['image','firsturl','视频封面', '<span class="text-danger">仅限于视频板块,其它板块无需添加视频封面</span>'],
                ['ueditor', 'content', '帖子内容'],
                ['radio','type','帖子类型','',['图片','文章','视频'],1],
                ['radio', 'status', '帖子状态', '', ['停用', '启用']],
                // ['radio', 'is_home', '首页推荐', '', ['停用', '启用']],
                ['radio','flag','是否置顶','',['否','是']],
                ['radio', 'stick', '是否加精', '', ['否', '是']]
            ])
            ->setFormData($info)
            ->layout(['sid' => 2, 'title' => 6 , 'keyword' => 3])
            ->fetch();
    }

}