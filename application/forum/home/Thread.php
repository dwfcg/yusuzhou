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



namespace app\forum\home;

use think\Db;

use think\Cookie;

use QiNiu\Auth;
/**

 * 前台首页控制器

 * @package app\forum\thread

 */
class Thread extends Common
{
    protected function _initialize()
    {
        parent::_initialize();
    }
//    搜索信息改动
    public function searchInfo()
    {
        $data = input('post.');
        $limit = 10;
        $title = $data['title'];
        $da = ['like','%'.$title.'%'];
//        本店商品搜索信息
        $ta['shop_goods'] = Db::name('shop_goods')->where(['title'=>$da])->where('shopstatus','eq',0)
            ->order('price desc')
            ->field('id,cid,title,tags,price,content,images,video,status,sort,goods_num,shou_num,click_num,com_num,is_free,thoughid,originid,rockid,kindid,weight,size,sku,add_time')
            ->limit($data['page']*$limit,$limit)
            ->select();
        foreach( $ta['shop_goods'] as &$th ){
            $th['images'] = array_filter(explode(',',$th['images']));
            $th['tags'] = array_filter(explode(',',$th['tags']));
            $th['add_time'] = date('Y-m-d H:i',$th['add_time']);
        }
        //闲置商品搜索信息
        $ta['shop_goods1'] = Db::name('shop_goods')->where(['title'=>$da])->where('shopstatus','eq',1)
            ->order('price desc')
            ->field('id,shopstatus,cid,title,tags,price,content,images,video,status,sort,goods_num,shou_num,click_num,com_num,is_free,thoughid,originid,rockid,kindid,weight,size,sku,add_time')
            ->limit($data['page']*$limit,$limit)
            ->select();
        foreach( $ta['shop_goods1'] as &$th ){
            $th['images'] = array_filter(explode(',',$th['images']));
            $th['tags'] = array_filter(explode(',',$th['tags']));
            $th['add_time'] = date('Y-m-d H:i',$th['add_time']);
        }
//        用户搜索
        $ta['user'] = Db::name('user')->where(['name'=>$da])
            ->order('id desc')
            ->field('id,name')
            ->limit($data['page']*$limit,$limit)
            ->select();
        foreach( $ta['user'] as $k =>$v ){
            $ta['user'][$k]['face']=Db::name('user_guan')->where('threadid',$ta['user'][$k]['id'])->count();
        }
//        帖子搜索
        $ta['forum_thread'] = Db::name('forum_thread')
            ->where(['sid'=>array('neq',4),'status'=>1,'title'=>$da])
            ->order('flag desc,add_time desc')
            ->field('id,title,conimage,images,type,zan_num,view_num,com_num,add_time')
            ->limit($data['page']*$limit,$limit)
            ->select();
        foreach( $ta['forum_thread'] as &$th ){
            $th['conimage'] = array_filter(explode(',',$th['conimage']));
            $th['images'] = array_filter(explode(',',$th['images']));
            $th['add_time'] = date('Y-m-d H:i',$th['add_time']);
        }
//        dump($ta);
        show_api($ta);
    }
    public function getSearch()
    {
        $data = input('post.');
        $limit = 10;
        $thread['search'] = Db::name('forum_thread')
                ->where(['sid'=>array('neq',4),'status'=>1,'title'=>['like','%'.$data['title'].'%']])
                ->order('flag desc,add_time desc')
                ->field('id,title,conimage,images,type,zan_num,view_num,com_num,add_time')
                ->limit($data['page']*$limit,$limit)
                ->select();
        foreach( $thread['search'] as &$th ){
            $th['conimage'] = array_filter(explode(',',$th['conimage']));
            $th['images'] = array_filter(explode(',',$th['images']));
            $th['add_time'] = date('Y-m-d H:i',$th['add_time']);
        }
       if (empty($thread['search'])) {
           show_api($thread,'暂无参数',0);
       }
        show_api($thread);
    }
    //ceshiguanjianzi前台文章搜索
    public function sear()
    {
        $data = input('post.');
        //$data['page'] = 0;有分页的时候测试接口必须写这个
        $limit = 10;
        $keyword = trim(input('keyword'));
        $where = array();
        $keyword && $where['title'] = array('like','%'.$keyword.'%');
        $list['wen'] = Db::name('forum_thread')->where($where)
               ->field('id,title,keyword,conimage,images,zan_num,view_num,com_num,type,add_time')
               ->order('id desc')
               ->limit($data['page']*$limit,$limit)
               ->select();
        foreach ($list['wen'] as $va) {
            $va['conimage'] = array_filter(explode(',',$va['conimage']));
            $va['images'] = array_filter(explode(',',$va['images']));
            $va['keyword'] = array_filter(explode(',',$va['keyword']));
            $va['add_time'] = date('Y-m-d H:i',$va['add_time']);
        }
        $list['goods'] = Db::name('shop_goods')->where($where)
                ->field('id,cid,title,tags,keyword,price,images,status,sort,add_time')
                ->order('price desc')
                ->limit($data['page']*$limit,$limit)
                ->select();
        foreach( $list['goods'] as &$th ){
            $th['images'] = array_filter(explode(',',$th['images']));
            $th['tags'] = array_filter(explode(',',$th['tags']));
            $th['keyword'] = array_filter(explode(',',$th['keyword']));
            $th['add_time'] = date('Y-m-d H:i',$th['add_time']);
        }
        if (empty($list['wen']) && empty($list['goods'])) {
           show_api($list,'暂无参数',0);
        }
        show_api($list);
    }
    /**
     * 发布帖子之图片 0
     * @author Lieber
     * @return mixed
     */
    public function publish()
    {
        $data = input('post.');
        $data['status'] = 1;
        $data['type'] = 0;
        $data['videos'] = '';
        $data['add_time'] = time();
        $data['uid'] = input('post.uid');
        $data['images'] = input('post.images');
        if(!$data['images'] || $data['images'] == ""){
            return "请确认图片是否上传成功";
        }
        $data['conimage'] = $data['images'];
        $validate = validate('Thread');
        $check = $validate->check($data);
        if( $check ){
            $info = "发布成功";
            $result = Db::name('forum_thread')->insertGetId($data);
            Db::name('user')->where(['id'=>$data['uid']])->setInc('fabu');
            $newdata=Db::name('user_setintegral')->select();
            Db::name('user')
                ->where('id',$data['uid'])->setInc('integraal',$newdata[0]['releasetie']);
        }else{
            $result = 0;
            $info = $validate->getError();
        }
        show_api($result,$info);
    }
    /*
     * 发布帖子之上传文本 1
     *  04.28
     */
    public function content()
    {
        $data = input('post.');
        $data['status'] = 1;
        $data['type'] = 1;
        $data['add_time'] = time();
        $data['uid'] = input('post.uid');
        $validate = validate('Thread');
        $check = $validate->check($data);
        if ( $check ) {
            $info = "发布成功";
            $result = Db::name('forum_thread')->insertGetId($data);
            Db::name('user')->where(['id'=>$data['uid']])->setInc('fabu');
            $newdata=Db::name('user_setintegral')->select();
            Db::name('user')
                ->where('id',$data['uid'])->setInc('integraal',$newdata[0]['releasetie']);
        }else{
            $result = 0;
            $info = $validate->getError();
        }
        show_api($result,$info);
    }
    /*
     * 发布帖子之上传视频
     *  04.28
     */
    public function vedio()
    {
        $video = input('request.urlVideo');
        $first = input('request.urlFirst');
        $data = ['videos' => $video, 'firsturl' => $first];
        $da = Db::name('forum_video')->where('videos',$video)->select();
        if (!$da) {
            $data = Db::name('forum_video')->insertGetId($data);
            $info = Db::name('forum_video')->where(['id'=>$data])->find();
            $info = array($info);
        }else{
            $info = Db::name('forum_video')->where(['videos'=>$video])->find();
            $info = array($info);
        }
        show_api($info);
    }
    //发布文章视频2
    public function video()
    {
        $data = input('post.');
        $data['status'] = 1;
        $data['type'] = 2;
        $data['add_time'] = time();
        $data['uid'] = input('post.uid');
        $vid = input('request.videoId');
        $video = Db::name('forum_video')->where(['id'=>$vid])->find();
        $data['vid'] = $video['id'];
        $data['videos'] = $video['videos'];
        $data['firsturl'] = $video['firsturl'];
        $data['title'] = input('post.title');
        $data['content'] = input('post.content');
        $validate = validate('Thread');
        $check = $validate->check($data);
        if ( $check ) {
            $info = '发布成功';
            $result = Db::name('forum_thread')->insertGetId($data);
            Db::name('user')->where(['id'=>$data['uid']])->setInc('fabu');
            $newdata=Db::name('user_setintegral')->select();
            Db::name('user')
                ->where('id',$data['uid'])->setInc('integraal',$newdata[0]['releasetie']);
        }else{
            $result = 0;
            $info = $validate->getError();
        }
        show_api($result,$info);
    }
    //获取个人视频
    public function getThreadvideo(){
        $uid = input('post.uid');
        $video = Db::name('forum_thread')->alias('a')
                ->join('user u','a.uid=u.id')
                ->where(['uid'=>$uid,'sid'=>4])
                ->field('a.id,a.sid,a.title,a.content,a.firsturl,type,a.zan_num,a.view_num,a.com_num,a.add_time,u.name,u.headimg,u.id as uid')
                // ->limit($data['page']*$page,$page)
                ->order('add_time desc')
                ->select();
        foreach( $video as &$th ){
            $th['firsturl'] = array_filter(explode(',',$th['firsturl']));
            $th['add_time'] = date('Y-m-d H:i',$th['add_time']);
        }
        show_api($video);
    }
    //获取个人文章
    public function getThreadwen(){
        $data = input('post.');
        // $uid = '50';
        $uid = input('post.uid');
        // $data['sid'] = array('neq',4);
        $wz = Db::name('forum_thread')->alias('a')
                ->join('user u','a.uid=u.id')
                ->where(['uid'=>$uid])
                ->field('a.id,a.sid,a.title,a.content,a.images,a.zan_num,a.view_num,a.conimage,a.com_num,a.add_time,a.type,u.name,u.headimg,u.id as uid')
                ->order('add_time desc')
                ->select();
        foreach ($wz as $key =>&$v) {
            $v['conimage'] = array_filter(explode(',',$v['conimage']));
            $v['images'] = array_filter(explode(',',$v['images']));
            $v['add_time'] = date('Y-m-d H:i',$v['add_time']);
        }
        show_api($wz);
    }
    //获取全部视频
    public function getQuanvideo()
    {
        $data = input('post.');//$data['page']=0;
        $dang = input('post.dangid');//$dang = '50';
        $page = 10;
        $video = Db::name('forum_thread')->alias('a')
                ->join('user u','a.uid=u.id')
                ->where(['a.type'=>2,'a.status'=>1])
                ->field('a.id,a.sid,a.title,a.content,a.videos,a.firsturl,type,a.zan_num,a.view_num,a.com_num,a.add_time,u.name,u.headimg,u.id as uid')
                 ->limit($data['page']*$page,$page)
                ->order('add_time desc')
                ->select();
        foreach( $video as $key => &$th ){
            $th['firsturl'] = array_filter(explode(',',$th['firsturl']));
            $th['add_time'] = date('Y-m-d H:i',$th['add_time']);
            $qw = Db::name('forum_wenzan')->where(['threadid'=>$video[$key]['id'],'userid'=>$dang])->count();
            if (!$qw) {
                $video[$key]['stat'] = 1;
            }else{
                $video[$key]['stat'] = 0;
            }
            $th['hui'] = Db::name('forum_shihui')->where(['shicomid'=>$video[$key]['id']])->limit(0,4)->select();
            foreach ($th['hui'] as $ke => &$va) {
                $th['hui'][$ke]['hcontent'] = json_decode($va['hcontent']);
            }
        }
        //dump($video);die;
        show_api($video);
    }
    //分类轮播图
    public function getThreadlun(){
        $id = input('post.sid');
        // $id = '2';
        $data = Db::name('forum_slide')->alias('s')
               ->join('forum_section f','s.sid=f.id')
               ->where(['sid'=>$id])
               ->field('s.img,s.link')
               ->select();
        show_api($data);

    }
    //截取富文本里面的所有图片
    // public function fuwen(){
    //     $nke = Db::name('forum_thread')->where('id',327)->find();
    //     $content = $nke['content'];
    //     preg_match_all('#src="([^"]+?)"#',$content, $the );
    //     // print_r($the[1]);die;
    //     $sd = implode(',',$the[1]);
    //     $na = Db::name('forum_thread')->where('id',327)->update(['images'=>$sd]);
    // }
    /**
     * 获取帖子
     * @author Lieber
     * @return mixed
     */
    public function getThreadList()
    {
        $page = 10;
        $data = input('post.');//$data['page']=0;
        $dangid = input('post.dangid');//$dangid=59;
        $map['t.status'] = 1;
        if( isset($data['sid']) ){
            $map['t.sid'] = $data['sid'];
        }
        if( isset($data['cid']) && $data['cid'] ){
            $map['t.cid'] = $data['cid'];
        }
        $thread = Db::name('forum_thread')->alias('t')->join('user u','t.uid = u.id')->where($map)
            ->field('t.id,t.uid,t.oid,t.cid,t.sid,t.title,t.content,t.conimage,t.images,t.videos,t.firsturl,t.status,t.type,t.videos,t.firsturl,t.zan_num,t.guan_num,t.view_num,t.com_num,t.zan_user,t.flag,t.stick,t.add_time,u.name,u.headimg,u.id as uid')
            ->limit($data['page']*$page,$page)
            ->order('flag desc,add_time desc')
            ->select();
        foreach( $thread as $key => &$th ){
            // dump($th['conimage']);die;
            $th['conimage'] = array_filter(explode(',',$th['conimage']));
            $th['images'] = array_filter(explode(',',$th['images']));
            $th['add_time'] = date('Y-m-d H:i',$th['add_time']);
            $qw = Db::name('forum_wenzan')->where(['userid'=>$dangid,'threadid'=>$th['id']])->count();
            if ($qw != 0) {
                $th['stat']=1;
            }else{
                $th['stat']=0;
            }
            if ($th['type'] == '2') {
                $th['hui']=Db::name('forum_thread')->alias('s')
                           ->join('forum_shihui w','s.id=w.shicomid')
                           ->where(['s.type'=>2,'w.shicomid'=>$thread[$key]['id']])
                           ->field('w.id,w.shicomid,w.hcontent,w.shi_uid,w.hui_uid,w.hui_status,w.shiname,w.huiname')
                           ->select();
                foreach ($th['hui'] as $ke => &$va) {
                       $th['hui'][$ke]['hcontent']=json_decode($va['hcontent']);
                }
            }
        }
//        dump($thread);die;
        show_api($thread);
    }
    public function get()
    {
        $page = 10;
        $data = input('post.');
        $map['t.status'] = 1;
        // $map['t.sid'] = array('neq',4);
        if( isset($data['sid']) ){
            $map['t.sid'] = $data['sid'];
        }
        if( isset($data['cid']) && $data['cid'] ){
            $map['t.cid'] = $data['cid'];
        }
        if( isset($data['uid']) ){
            $map['t.uid'] = $data['uid'];
        }
        // if (isset($data['flag'])) {
        //     $map['t.flag'] = $data['flag'];
        // }
        $thread = Db::name('forum_thread')->alias('t')->join('user u','t.uid = u.id')->where($map)
        ->field('t.id,t.uid,t.oid,t.cid,t.sid,t.title,t.content,t.conimage,t.images,t.videos,t.firsturl,t.status,t.type,t.zan_num,t.guan_num,t.view_num,t.com_num,t.zan_user,t.flag,t.stick,t.add_time,u.name,u.headimg,u.id as uid')
        ->limit($data['page']*$page,$page)
        ->order('flag desc,add_time desc')
        ->select();
        foreach( $thread as &$th ){
            // dump($th['conimage']);die;
            $th['conimage'] = array_filter(explode(',',$th['conimage']));
            $th['images'] = array_filter(explode(',',$th['images']));
            $th['add_time'] = date('Y-m-d H:i',$th['add_time']);
        }
        show_api($thread);
    }
    /**
     * 获取分类、版块信息
     * @author Lieber
     * @return mixed
     */
    public function getThreadInfo()
    {
        $field = 'id,tionname,icon';
        $orderby = 'sort asc';
        $condition = array('status'=>1);
        $data['section'] = Db::name('forum_section')->where($condition)->order($orderby)->field($field)->select();
        $data['category'] = Db::name('forum_cate')->where(['sid'=>array('neq',8),'status'=>1])->order($orderby)->field('id,sid,name')->select();
        $slides = Db::name('slide')->where('status',1)->order('sort asc')->select();
        $data['slider'] = $slides;
        $home = explode(',',config('home_imgs'));
        $array1 = array();
        foreach($home as $key=>$row){
            $array1['img'.$key] = $row;
        }
        $url = explode("\r\n",config('home_url'));
        $array2 = array();
        foreach($url as $key=>$row){
            $array2['img'.$key] = $row;
        }
        $homes = array_values(array_merge_recursive($array1,$array2));
        $data['home'] = $homes;
        show_api($data);
    }
    //二级分类
    public function getCategory()
    {
        $condition = array('status'=>1);
        if( input('sid') ){
            $condition['sid'] = input('sid');
        }
        $data = Db::name('forum_cate')->where($condition)->order('sort asc')->field('id,sid,name')->select();
        show_api($data);
    }
    //sid
    public function cate()
    {
        $page = 10;
        $data = input('post.');
        $data['page']=0;
        $sid = input('post.sid');
        //$sid = 6;
        $da = input('post.forum');
         //$da = 3;
        $cid = input('post.cid');
        //$cid = 22;
        if ($cid != 0) {
            $da = Db::name('forum_thread')->where(['sid'=>$sid,'cid'=>$cid,'status'=>1])->field('id,uid,oid,vid,cid,sid,title,content,conimage,images,videos,firsturl,status,type,zan_num,guan_num,view_num,com_num,flag,stick,add_time')->limit($data['page']*$page,$page)->order('flag desc,add_time desc')->select();
            //echo Db::name('forum_thread')->getLastSql();die;
            foreach ($da as &$v) {
                $v['conimage'] = array_filter(explode(',',$v['conimage']));
                $v['images'] = array_filter(explode(',',$v['images']));
                $v['add_time'] = date('Y-m-d H:i',$v['add_time']);
            }
            show_api($da);
        }
        // else if ($cid == 0) {
        //     show_api('','无数据',2);
        // }
        if ($da == 3) {
            $daa = Db::name('forum_thread')->where(['sid'=>$sid,'status'=>1])->where('add_time','>',(time()-7*24*3600))->field('id,uid,oid,vid,cid,sid,title,content,conimage,images,videos,firsturl,status,type,zan_num,guan_num,view_num,com_num,flag,stick,add_time')->limit($data['page']*$page,$page)->order('add_time desc')->select();
            //echo Db::name('forum_thread')->getLastSql();die;
            foreach ($da as &$v) {
                $v['conimage'] = array_filter(explode(',',$v['conimage']));
                $v['images'] = array_filter(explode(',',$v['images']));
                $v['add_time'] = date('Y-m-d H:i',$v['add_time']);
            }
          show_api($daa);
        }else if ($da == 2) {
            $da = Db::name('forum_thread')->where(['sid'=>$sid,'stick'=>1,'status'=>1])->field('id,uid,oid,vid,cid,sid,title,content,conimage,images,videos,firsturl,status,type,zan_num,guan_num,view_num,com_num,flag,stick,add_time')->limit($data['page']*$page,$page)->order('stick desc,add_time desc')->select();
            foreach ($da as &$v) {
                $v['conimage'] = array_filter(explode(',',$v['conimage']));
                $v['images'] = array_filter(explode(',',$v['images']));
                $v['add_time'] = date('Y-m-d H:i',$v['add_time']);
            }
          show_api($da);
        }else if ($da == 1) {
            $da = Db::name('forum_thread')->where(['sid'=>$sid,'view_num'=>array('egt',100),'zan_num'=>array('egt',10),'status'=>1])->field('id,uid,oid,vid,cid,sid,title,content,conimage,images,videos,firsturl,status,type,zan_num,guan_num,view_num,com_num,flag,stick,add_time')->limit($data['page']*$page,$page)->order('flag desc,add_time desc')->select();
            foreach ($da as &$v) {
                $v['conimage'] = array_filter(explode(',',$v['conimage']));
                $v['images'] = array_filter(explode(',',$v['images']));
                $v['add_time'] = date('Y-m-d H:i',$v['add_time']);
            }
          show_api($da);
        }else if ($da == 0) {
            $daa = Db::name('forum_thread')->where(['sid'=>$sid,'status'=>1])->field('id,uid,oid,vid,cid,sid,title,content,conimage,images,videos,firsturl,status,type,zan_num,guan_num,view_num,com_num,flag,stick,add_time')->limit($data['page']*$page,$page)->order('add_time desc')->select();
            foreach ($daa as &$v) {
                $v['conimage'] = array_filter(explode(',',$v['conimage']));
                $v['images'] = array_filter(explode(',',$v['images']));
                $v['add_time'] = date('Y-m-d H:i',$v['add_time']);
            }
          show_api($daa);
        }

    }
}