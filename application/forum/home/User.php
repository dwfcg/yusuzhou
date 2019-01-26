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
/**
 * 前台首页控制器
 * @package app\forum\thread
 */
class User extends Common
{
    public $uid;
    protected function _initialize()
    {
        $user = json_decode(Cookie::get('userLogin',''),true);
        $this->uid = $user['id'];
    }
    //视频
    public function shipin()
    {
        $data = input('post.');
        $page = 10;
        $shi = Db::name('forum_thread')->alias('a')
               ->join('user u','a.uid=u.id')
               ->where(['a.sid'=>array('eq',4),'a.status'=>1])
               ->field('a.id,a.uid,a.oid,a.cid,a.sid,a.title,a.videos,a.firsturl,a.status,a.zan_num,a.guan_num,a.view_num,a.com_num,a.zan_user,a.flag,a.stick,a.add_time,u.name,u.headimg,u.id as uid')
               ->limit($data['page']*$page,$page)
               ->order('flag desc,add_time desc')
               ->select();
        foreach ($shi as &$v) {
            $v['videos'] = array_filter(explode(',',$v['videos']));
            $v['firsturl'] = array_filter(explode(',',$v['firsturl']));
            $v['add_time'] = date('Y-m-d H:i',$v['add_time']);
        }
        show_api($shi);
    }
    //保存草稿
    public function draft()
    {
        $uid = input('post.uid');
        $title = input('post.title');
        $con = input('post.content');
        $cons = input('post.cons');
        $time = time();
        $as = Db::name('forum_draft')->where(['uid'=>$uid])->field('uid')->find();
        if (empty($as['uid'])) {
            if (empty($title) && empty($con) && empty($cons)) {
                show_api('','当前无内容',4);
            }else{
                $data = Db::name('forum_draft')->insert(['uid'=>$uid,'title'=>$title,'content'=>$con,'cons'=>$cons,'add_time'=>$time]);
                show_api($data,'保存草稿',1);

            }
        }else if(!empty($as['uid'])){
            if (empty($title) && empty($con) && empty($cons)) {
                show_api('','',3);
            }else{
                $data = Db::name('forum_draft')->where(['uid'=>$uid])->update(['uid'=>$uid,'title'=>$title,'content'=>$con,'cons'=>$cons,'add_time'=>$time]);
                show_api($data,'更新成功',2);                
            }
        }
    }
    //判断是否有草稿
    public function darsf()
    {
        $uid = input('post.uid');
        $data = Db::name('forum_draft')->where(['uid'=>$uid])->find();
        if (empty($data['uid'])) {
            show_api($data,'没有草稿',1);
        }else if(!empty($data['uid'])){
            show_api($data,'有草稿',2);
        }
    }
    //删除草稿
    public function shan()
    {
        $uid = input('post.uid');
        $data = Db::name('forum_draft')->where(['uid'=>$uid])->delete();
        show_api($data);
    }
    //最新文章
    public function zuixin(){
        $page = 10;
        $data = input('post.');
        $asd = Db::name('forum_thread')->alias('a')
                ->join('user u','a.uid=u.id')
                ->where(['a.status'=>1])
                ->field('a.id,a.uid,a.oid,a.cid,a.sid,a.title,a.conimage,a.images,a.status,a.zan_num,a.guan_num,a.type,a.view_num,a.com_num,a.zan_user,a.flag,a.stick,a.add_time,u.name,u.headimg,u.id as uid')
                ->limit($data['page']*$page,$page)
                ->order('flag desc,add_time desc')
                ->select();
        foreach ($asd as &$v) {
            $v['conimage'] = array_filter(explode(',',$v['conimage']));
            $v['images'] = array_filter(explode(',',$v['images']));
            $v['add_time'] = date('Y-m-d H:i',$v['add_time']);
        }

        show_api($asd);
    }
    //精华文章
    public function jinghua(){
        $page = 10;
        $data = input('post.');
        $jing = Db::name('forum_thread')->alias('a')
               ->join('user u','a.uid=u.id')
               ->where(['a.status'=>1,'a.stick'=>array('eq',1)])
               ->field('a.id,a.uid,a.oid,a.cid,a.sid,a.title,a.conimage,a.images,a.status,a.type,a.zan_num,a.guan_num,a.view_num,a.com_num,a.zan_user,a.flag,a.stick,a.add_time,u.name,u.headimg,u.id as uid')
               ->limit($data['page']*$page,$page)
               ->order('stick desc,add_time desc')
               ->select();
        foreach ($jing as &$v) {
            $v[' '] = array_filter(explode(',',$v['conimage']));
            $v['images'] = array_filter(explode(',',$v['images']));
            $v['add_time'] = date('Y-m-d H:i',$v['add_time']);
        }
        show_api($jing);
    }
    //热帖文章
    public function retie(){
        $page = 10;
        $data = input('post.');
//        $data['page']=0;
        $dangid = input('post.dangid');
//        $dangid=59;
        $re = Db::name('forum_thread')->alias('a')
            ->join('user u','a.uid=u.id')
            ->where(['a.status'=>1,'a.view_num'=>array('egt',100),'a.zan_num'=>array('egt',10)])
            ->field('a.id,a.uid,a.oid,a.cid,a.sid,a.title,a.conimage,a.images,a.status,a.videos,a.firsturl,a.type,a.zan_num,a.guan_num,a.view_num,a.com_num,a.zan_user,a.flag,a.stick,a.add_time,u.name,u.headimg,u.id as uid')
            ->limit($data['page']*$page,$page)
            ->order('flag desc,add_time desc')
            ->select();            
        foreach ($re as $key => &$v) {
            $v['conimage'] = array_filter(explode(',',$v['conimage']));
            $v['images'] = array_filter(explode(',',$v['images']));
            $v['add_time'] = date('Y-m-d H:i',$v['add_time']);
            $qw = Db::name('forum_wenzan')->where(['userid'=>$dangid,'threadid'=>$v['id']])->count();
            if ($qw != 0) {
                $v['stat']=1;
            }else{
                $v['stat']=0;
            }
            if ($v['type'] == '2') {
                $v['hui']=Db::name('forum_thread')->alias('s')
                           ->join('forum_shihui w','s.id=w.shicomid')
                           ->where(['s.type'=>2,'w.shicomid'=>$re[$key]['id']])
                           ->field('w.id,w.shicomid,w.hcontent,w.shi_uid,w.hui_uid,w.hui_status,w.shiname,w.huiname')
                           ->select();
                foreach ($v['hui'] as $ke => &$va) {
                       $v['hui'][$ke]['hcontent']=json_decode($va['hcontent']);
                }
            }
        }
        //dump($re);die;
        show_api($re);
    }
    //问答
    public function wenda(){
        $page = 10;
        $data = input('post.');
        $wen = Db::name('forum_thread')->alias('a')
            ->join('user u','a.uid=u.id')
            ->where(['a.sid'=>array('eq',11),'a.status'=>1])
            ->field('a.id,a.uid,a.oid,a.cid,a.sid,a.title,a.conimage,a.images,a.status,a.zan_num,a.guan_num,a.view_num,a.com_num,a.zan_user,a.flag,a.stick,a.add_time,u.name,u.headimg,u.id as uid')
            ->limit($data['page']*$page,$page)
            ->order('add_time desc')
            ->select();
        foreach ($wen as &$v) {
            $v['conimage'] = array_filter(explode(',',$v['conimage']));
            $v['images'] = array_filter(explode(',',$v['images']));
            $v['add_time'] = date('Y-m-d H:i',$v['add_time']);
        }
        show_api($wen);
    }
    /**
     * 获取帖子
     * @author Lieber
     * @return mixed
     */
    public function getThreadList()
    {
        $page = 10;
        $data = input('post.');
        $data['start'] = isset($data['start'])?$data['start']:0;
        $map['uid'] = $this->uid;
        $thread = Db::name('forum_thread')->where($map)
                ->order('add_time desc')
                ->field('id,uid,oid,vid,cid,sid,title,content,conimage,images,videos,firsturl,status,type,zan_num,guan_num,view_num,com_num,zan_user,flag,stick,add_time')
                ->limit($data['start'],$page)
                ->select();
        foreach( $thread as &$th ){
            $th['conimage'] = array_filter(explode(',',$th['conimage']));
            $th['images'] = current(explode(',',$th['images']));
        }
        if( $data['start'] ){
            $this->assign('thread',$thread);
            return $this->fetch('thread_list');
        }else{
            $page_count = Db::name('forum_thread')->where($map)->count();
            $this->assign('thread',$thread);
            $this->assign('page_count',$page_count);
            return $this->fetch('thread');
        }
    }
    //删除帖子
    public function del()
    {
	    $id = input('post.id');
	    $uid = input('post.uid');
	    Db::name('user')->where('uid',$uid)->setDec('fabu');
        $result = Db::name('forum_thread')->where(['uid'=>$uid,'id'=>$id])->delete();
        echo json_encode(['status'=>$result]);
    }
}
