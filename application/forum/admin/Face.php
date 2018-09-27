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

 * 版块控制器

 * @package app\cms\admin

 */

class Face extends Admin

{
	public function index()
  {
		$map = $this->getMap();
		$data_list = Db::name('forum_face')->where($map)->order('addtime asc')->paginate();
		return ZBuilder::make('table')
		    ->addColumns([
                  ['id','ID'],
                  ['name','展示位置'],
                  ['first','视频封面','img_url'],
                  ['video','宣传视频','link',url('edit',['id'=>'__id__'])],
                  ['status','宣传状态','status','',['关闭', '开启']],
                  ['zhanshi','是否展示在前台','status','',['不展示', '展示']],
                  ['addtime','更新时间','datetime'],
                  ['right_button','操作','btn']
		    	])
            // ->addTopButtons('add')
            ->addRightButtons(['edit'])
            ->setRowList($data_list)
            ->fetch(); // 渲染模板
	}
	//添加
	public function add(){
        // 保存数据
        if ($this->request->isPost()) {

            // 表单数据

            $data = $this->request->post();

            $data['add_time'] = time();

            if ($result = Db::name('forum_face')->insert($data)) {

                $this->success('添加成功', 'index');

            } else {

                $this->error('添加失败');

            }

        }
        return ZBuilder::make('form')
        	->addFormItems([
                   ['hidden','id'],
                   ['file', 'video', '宣传视频', '<span class="text-danger">视频大小必须为16:9比列</span>'],
                   ['image', 'first', '视频封面', '<span class="text-danger">图片大小必须为16:9比列</span>'],
                   ['radio','status', '视频状态', '', ['关闭', '开启']],
                   ['radio','zhanshi','是否展示在前台','',['否','是']]
        		])
        	->layout(['video' => 2, 'first'=>3, 'status'=>3])
        	->fetch();
    }
    //编辑
    public function edit($id = null){
		if ($id === null) $this->error('缺少参数');
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            $data['addtime'] = time();
            if ($advert = Db::name('forum_face')->where('id',$data['id'])->update($data)) {
                $this->success('编辑成功', 'index');
            } else {
               $this->error('编辑失败');
            }
        }
        $info = Db::name('forum_face')->find($id);
        return ZBuilder::make('form')
            ->addFormItems([
                   ['hidden','id'],
                   ['text', 'video', '宣传视频url', '<span class="text-danger">图片大小必须为16:9比列</span>'],
                   ['image', 'first', '视频封面', '<span class="text-danger">图片大小必须为16:9比列</span>'],
                   ['radio','status','视频状态', '', ['关闭', '开启']],
                   ['radio','zhanshi','是否展示在前台','',['否','是']]
            	])
            ->setFormData($info)
            ->layout(['first' => 3, 'video' => 7,'radio'=>3])
            ->fetch();
    }
}