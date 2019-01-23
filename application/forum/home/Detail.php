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

class Detail extends Common
{
    protected function _initialize()
    {
        parent::_initialize();
    }
    //视频详情
    public function video_detail(){
        $id = input('id');
        $dangid = input('uid');
        $thread = Db::name('forum_thread')->alias('t')->join('user u','t.uid = u.id')->where([
            't.id'=>$id    
        ])->field('t.id,t.uid,t.sid,t.title,t.content,t.videos,t.firsturl,t.status,t.zan_num,t.guan_num,t.view_num,t.com_num,t.zan_user,t.flag,t.stick,t.add_time,u.name,u.headimg,u.id as uid')->find();
        $da['threadid'] = $thread['uid'];
        $guan = Db::name('user_guan')->where(['dangid'=>$dangid,'threadid'=>$da['threadid']])->count();
        $zan = Db::name('forum_wenzan')->where(['userid'=>$dangid,'threadid'=>$id])->count();
        $comment = Db::name('forum_comment')->alias('c')->join('user u','c.uid = u.id')->where('c.tid',$id)->field('c.*,u.name,u.headimg,u.id as uid')->select();
        $recom = Db::name('forum_thread')->where([
            'id'=>array('neq',$id),
            'status'=>1,
        ])->order('add_time desc')->limit(4)->select();
        Db::name('forum_thread')->where('id',$id)->setInc('view_num');
        $this->assign('guan',$guan);
        $this->assign('zan',$zan);
        $this->assign('recom',$recom);
        $this->assign('thread',$thread);
        $this->assign('comment',$comment);
        return $this->fetch();
    }
    // 文章详情
    public function index(){
        $id = input('id');//$id=297;
        $dangid = input('uid');$uid=4;
        $thread = Db::name('forum_thread')->alias('t')->join('user u','t.uid = u.id')
                  ->where(['t.id'=>$id])
                  ->field('t.id,t.uid,t.oid,t.cid,t.sid,t.title,t.content,t.conimage,t.images,t.videos,t.firsturl,t.status,t.zan_num,t.guan_num,t.view_num,t.com_num,t.zan_user,t.flag,t.stick,t.add_time,u.name,u.headimg,u.id as uid')
                  ->find();
        $da['threadid'] = $thread['uid'];
        $guan = Db::name('user_guan')->where(['dangid'=>$dangid,'threadid'=>$da['threadid']])->count();
        $zan = Db::name('forum_wenzan')
                    ->where(['userid'=>$dangid,'threadid'=>$id])
                    ->count();
        $thread['content'] = str_replace("<img "," <img class=\"lazy\"",$thread['content']);//替换img title=\"\" alt=\"\"
        $thread['images'] = array_filter(explode(',',$thread['images']));
        $comment = array();
        $arr = Db::name('forum_comment')->alias('c')
                    ->join('user u','c.uid = u.id')
                    ->where(['c.tid'=>$id,'c.status'=>1])
                    ->field('c.id as cid,c.uid as cuid,c.tid,c.images,c.content,c.zan_num,c.hui_num,c.add_time,u.name as uname,u.headimg,u.id as uid')
                    ->order('add_time desc')
                    ->select();
        $comment = $arr;
        foreach ($comment as $key => &$va) {
               $comment[$key]['content'] = json_decode($va['content']);
                $qw = Db::name('forum_zan')->where(['threadid'=>$id,'pinid'=>$comment[$key]['cid'],'userid'=>$dangid,'pingid'=>$comment[$key]['uid']])->count();
                if (!$qw) {
                    $comment[$key]['stat'] = 1;
                }else{
                    $comment[$key]['stat'] = 0;
                }
                $va['mos'] = Db::name('forum_reply')->where(['comment_id'=>$comment[$key]['cid']])->field('id,comment_id,content as acontent,from_uid,to_uid,fname,toname,reply_status')->limit(0,3)
                            ->select();
                foreach($va['mos'] as $ke =>&$vs)
                {
                    $re_str = substr($vs['acontent'],1,-1);
                    // $comment[$key][$ke]['acontent']=$this->unicodeDecode($re_str);a
                    $va['mos'][$ke]['acontent'] = $this->unicodeDecode($re_str);
                    // $va['mos'][$ke]['acontent'] = json_decode($vs['acontent']);
                }
           }
        $recom = Db::name('forum_thread')->where(['id'=>array('neq',$id),'sid'=>$thread['sid'],'status'=>1])->order('add_time desc')->limit(6)->select();
        Db::name('forum_thread')->where('id',$id)->setInc('view_num');
        $url='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
        Db::name('forum_thread')->where(['id'=>$id])->update(['url'=>$url]);
        $this->assign('guan',$guan);
        $this->assign('zan',$zan);
        // $this->assign('hui',$hui);
        $this->assign('recom',$recom);
        $this->assign('thread',$thread);
        $this->assign('comment',$comment);
        return $this->fetch();
    }
  //转json
     public function unicodeDecode($unicode_str){
        $json = '{"str":"'.$unicode_str.'"}';
        $arr = json_decode($json,true);
        if(empty($arr)) return '';
        return $arr['str'];
    }
    //关注用户
    public function guan(){
        $dangid = input('post.uid');//当前用户id
        $threadid = input('post.tid');//文章用户id
        $status = input('post.status');//状态0关注1取消关注
        $time = time();
        if ($dangid == $threadid) {
           return '您不能关注您自己';
        }
        $data = Db::name('user_guan')->where(['dangid'=>$dangid,'threadid'=>$threadid])->select();
        if (!$data) {
            $gu = Db::name('user_guan')->insert(['dangid'=>$dangid,'threadid'=>$threadid,'status'=>$status,'guan_time'=>$time]);
            $gua = Db::name('user')->where(['id'=>$dangid])->setInc('guanzhu');//当前用户关注人加一
            $guan = Db::name('user')->where(['id'=>$threadid])->setInc('fensi');//被关注人的粉丝加一
            show_api($gu);
        }else{
           $guan=Db::name('user_guan')->where(['dangid'=>$dangid,'threadid'=>$threadid,'status'=>0])->find();
            show_api($guan,'已关注');
        }
    }
    //取消关注用户
    public function quxiao(){
        $status = input('post.status');
        $dangid = input('post.uid');
        $threadid = input('post.tid');
        $data = Db::name('user_guan')->where(['dangid'=>$dangid,'threadid'=>$threadid])->find();
        if ($data != '') {
            $guan = Db::name('user_guan')->where(['id'=>$data['id']])->delete();
            $xiao = Db::name('user')->where(['id'=>$dangid])->setDec('guanzhu');//当前用户关注人减一
            $xiao = Db::name('user')->where(['id'=>$threadid])->setDec('fensi');//被关注人的粉丝减一
            show_api($guan,'取消关注');
        }else if($data == ''){
            show_api($data,'已取消关注',2);
        }
    }
    //我关注的用户
    public function focus(){
        $dangid = input('post.dangid');
        $gz = Db::name('user')->alias('a')
            ->join('user_guan u','a.id=u.threadid')
            ->where(['u.dangid'=>$dangid])
            ->field('a.id,a.sex,a.name,a.headimg,a.fensi,u.guan_time')
            ->select();
        // print_r($gz);die;
        foreach ($gz as $key=>&$th ) {
            $sex=['1'=>'男','2'=>'女'];
            $gz[$key]['sex'] = $sex[$th['sex']];
            // $gz[$key]['sex']=$gz[$key]['sex']==1?"男":"女";
        }
        // print_r($gz);die;
        show_api($gz);
    }
    //关注人的动态
    public function guandong()
    {
        $page = 10;
        $data = input('post.');
        $data['page']=2;
        $dangid = input('post.dangid');
        //$where['type']=array('neq',2);
//        $dangid = '59';
        $guan = Db::name('user_guan')->alias('a')
                ->join('forum_thread c','a.threadid=c.uid')
                ->where('a.dangid',$dangid)
                ->where('c.status',1)
                ->field('c.id,c.uid,c.oid,c.vid,c.cid,c.sid,c.title,c.keyword,c.content,c.conimage,c.images,c.videos,c.firsturl,c.status,c.type,c.zan_num,c.guan_num,c.view_num,c.com_num,c.flag,c.stick,c.add_time')
                ->order('flag desc,add_time desc')
                ->limit($data['page']*$page,$page)
                ->select();
        foreach ($guan as $key => &$va){
           // dump($va['type']);
            $va['conimage'] = array_filter(explode(',',$va['conimage']));
            $va['images'] = array_filter(explode(',',$va['images']));
            $va['add_time'] = date('Y-m-d H:i',$va['add_time']);
            $qw = Db::name('forum_wenzan')->where(['userid'=>$dangid,'threadid'=>$va['id']])->count();
            if ($qw != 0) {
                $va['stat']=1;
            }else{
                $va['stat']=0;
            }
            if ($va['type'] == '2') {
                $va['hui']=Db::name('forum_thread')->alias('s')
                           ->join('forum_shihui w','s.id=w.shicomid')
                           ->where(['s.type'=>2,'w.shicomid'=>$guan[$key]['id']])
                           ->field('w.id,w.shicomid,w.hcontent,w.shi_uid,w.hui_uid,w.hui_status,w.shiname,w.huiname')
                           ->select();
                foreach ($va['hui'] as $ke => &$v) {
                       $va['hui'][$ke]['hcontent']=json_decode($v['hcontent']);
                }
               // echo Db::name('forum_shihui')->getLastSql();
            }
        }
//       var_dump($guan);die;
        show_api($guan);
    }
  //ceshi没用
    public function ceshi()
    {
        $data = input('post.');
      $data['page']=0;
        $page = 10;
        $dangid = input('post.dangid');
      $dangid = 59;
        $ce = Db::name('user_guan')->where(['dangid'=>$dangid,'status'=>0])->field('threadid')->select();
      var_dump($ce);die;
        foreach ($ce as $k => $v) {
           $shi[$k] = Db::name('forum_thread')->alias('a')
                   ->join('user_guan b','a.uid=b.threadid')
                   ->join('user c','a.uid=c.id')
                   ->where(['a.uid'=>$v['threadid'],'a.status'=>1])
                   ->field('a.id as aid,a.uid,a.title')
                   //->limit($data['page']*$page,$page)
                   //->order('add_time desc')
                   ->select();
        }
      var_dump($shi);die;
       foreach ($shi[$k] as $value) {
             $value = implode(',',$value);
             $temp[]=$value;
        }
        $temp = array_unique($temp);
        foreach ($temp as $key => $value) {
            $temp[$key] = explode(',',$value);
        }
      var_dump($temp);die;
      show_api($temp);
    }
    //点赞文章
    public function dianzan(){
        $thread = input('post.threadid');
        $userid = input('post.userid');
        $status = input('post.status');
        $data = Db::name('forum_wenzan')->where(['threadid'=>$thread,'userid'=>$userid])->select();
        if (!$data) {
            $dian=Db::name('forum_wenzan')->insert(['threadid'=>$thread,'userid'=>$userid,'status'=>$status]);
            $zan = Db::name('forum_thread')->where(['id'=>$thread])->setInc('zan_num');
            $fa = Db::name('forum_thread')->where(['id'=>$thread])->find();
            $zan = Db::name('user')->where(['id'=>$fa['uid']])->setInc('huozan');
            $zan = Db::name('forum_thread')->where(['id'=>$thread])->field('zan_num')->find();
            show_api($zan);
        }else{
            $zan=Db::name('forum_wenzan')->where(['threadid'=>$thread,'userid'=>$userid,'status'=>0])->find();
            show_api($zan,'已点赞');
        }
    }
    //取消文章点赞
    public function quzan(){
        $thread = input('post.threadid');
        $userid = input('post.userid');
        $status = input('post.status');
        $data = Db::name('forum_wenzan')->where(['threadid'=>$thread,'userid'=>$userid])->find();
        if ($data != '') {
            $quzan = Db::name('forum_wenzan')->where(['id'=>$data['id']])->delete();
            $xz = Db::name('forum_thread')->where(['id'=>$thread])->setDec('zan_num');
            $fa = Db::name('forum_thread')->where(['id'=>$thread])->find();
            Db::name('user')->where(['id'=>$fa['uid']])->setDec('huozan');
            $xz = Db::name('forum_thread')->where(['id'=>$thread])->field('zan_num')->find();
            show_api($xz,'取消点赞');
        }else if($data == '') {
            show_api($data,'已取消点赞',2);
        }
    }
    //视频评论页面
    public function video_comment(){
        $id = input('id');
        $thread = Db::name('forum_thread')->find($id);
        $this->assign('thread',$thread);
        return $this->fetch();
    }
    //视频全部评论
    public function videoping(){
        $id = input('post.id');
        $uid = input('post.userid');
        // $id = '248';$uid='50';
        $data = array();
        $zm = Db::name('forum_thread')->alias('a')
               ->join('forum_comment b','a.id=b.tid')
               ->join('user c','b.uid=c.id')
               ->where(['tid'=>$id])
               ->field('a.id,b.id as b_id,b.uid,b.content,b.images,b.zan_num,b.com_num,b.add_time,c.name,c.headimg')
               ->order('add_time desc')
               ->select();
        // echo Db::name('forum_comment')->getLastSql();
        // var_dump($zm);die;
        $data = $zm;
        foreach( $data as $key=>&$th ){
            $data[$key]['content'] = json_decode($th['content']);
            $qwe =Db::name('forum_zan')->where(['threadid'=>$id,'pinid'=>$data[$key]['b_id'],'userid'=>$uid])->find();
            if (!$qwe) {
                $data[$key]['stat'] = 1;
            }else{
                $data[$key]['stat'] = 0;
            }
            $th['images'] = array_filter(explode(',',$th['images']));
            $th['headimg'] = array_filter(explode(',',$th['headimg']));
        }
            show_api($data);

    }
    // 文章评论
    public function comment(){
        $id = input('id');
        $thread = Db::name('forum_thread')->find($id);
        $this->assign('thread',$thread);
        return $this->fetch();
    }
    // 文章评论
    public function comment_add(){
        $data = input('post.');
        $data['tid'] = input('post.tid');
        $data['uid'] = input('post.uid');
        $data['headimg'] = input('post.headimg');
        $data['uname'] = input('post.username');
        $data['content'] = input('post.content');
        $data['content'] = json_encode($data['content']);
        $data['add_time'] = time();
        // var_dump($data);die;
        $thread = Db::name('forum_thread')->find($data['tid']);
        Db::name('forum_thread')->where('id',$data['tid'])->setInc('com_num');
        $result = Db::name('forum_comment')->insertGetId($data);
        $result && Db::name('thread_notice')->insert([
            'tid'=>$thread['id'],
            'uid'=>$data['uid'],
            'type'=>2,
            'add_time'=>time()
        ]);
        $msg = $result? '评论成功':'评论失败';
        show_api($result,$msg);
    }
      //回复评论
    public function huifu()
    {
        $data = input('post.');
        $type = input('post.reply_status');$type=1;
        $uid = input('post.comment_id');//根评论id对应评论里面的自增id
        $uid=240;
        $bei = input('post.from_uid');//被回复人的id对应评论里面的uid
        $bei=50;
        $dang = input('post.to_uid');//回复人id
        $dang=59;
        $content = input('post.content');//回复内容
        $nei = json_encode($content);
        $time = time();
        $fu = Db::name('user')->where(['id'=>$bei])->field('id,name')->find();
        $to = Db::name('user')->where(['id'=>$dang])->field('id,name')->find();
        Db::name('forum_comment')->where(['id'=>$uid])->setInc('hui_num');
        $data = Db::name('forum_reply')->insert(['comment_id'=>$uid,'from_uid'=>$bei,'to_uid'=>$dang,'content'=>$nei,'reply_status'=>$type,'fname'=>$fu['name'],'toname'=>$to['name'],'addtime'=>$time]);
        if ($data == 1) {
            $da = Db::name('forum_reply')
                  ->where(['from_uid'=>$bei])
                  ->field('id,comment_id,from_uid,to_uid,content,reply_status,addtime,fname,toname')
                  ->find();
            $da['content'] = json_decode($da['content']);
            // $da['addtime'] = date('Y-m-d H:i',$da['addtime']);
            show_api($da,'回复成功');
            }elseif($data != 1){
                show_api($data,'回复失败',2);
            }
    }
    //删除评论
    public function shanchu()
    {
        $id = input('post.id');
        $da = Db::name('forum_reply')->where(['id'=>$id])->find();
        Db::name('forum_comment')->where(['id'=>$da['comment_id']])->setDec('hui_num');
        $data = Db::name('forum_reply')->where(['id'=>$id])->delete();
        if ($data == 1) {
            show_api($data,'删除成功');
        }else{
            show_api($data,'删除失败',2);
        }
    }
    //根评论下面的回复
    public function suoyou()
    {
        $id = input('post.comment_id');//根评论id
        $dang = input('post.dangid');
        $data['gen'] = Db::name('forum_comment')->where(['id'=>$id])
                ->field('id,uid,tid,images,content,zan_num,hui_num,status,uname,headimg,add_time')
                ->find();
//        dump($id);
        $data['gen']['content']=json_decode($data['gen']['content']);
        $data['gen']['images']=array_filter(explode(',',$data['gen']['images']));
        $data['gen']['add_time']=date('Y-m-d H:i',$data['gen']['add_time']);
        $qw = Db::name('forum_zan')->where(['threadid'=>$data['gen']['tid'],'pinid'=>$data['gen']['id'],'userid'=>$dang,'pingid'=>$data['gen']['uid']])->count();
        if (!$qw) {
            $data['gen']['stat'] = 1;
        }else{
            $data['gen']['stat'] = 0;
        }
        $data['hui'] = Db::name('forum_reply')->where(['comment_id'=>$data['gen']['id']])
         	    ->field('id,comment_id,from_uid,to_uid,content as acontent,fname,toname,reply_status,addtime')
                ->select();
//        dump($data['hui']);
            foreach ($data['hui'] as $key => &$va) {
                $data['hui'][$key]['acontent']=json_decode($va['acontent']);
            }
        //var_dump($data);die;
        show_api($data);
    }
    //文章下面的所有评论
    public function wensuo()
    {
        $tid = input('post.tid');//$tid=379;
        $dang = input('post.dangid');//$dang=7;
        $arr = array();
        $cha = Db::name('forum_comment')->where(['tid'=>$tid])
                ->field('id as cid,uid,images,content,zan_num,hui_num,uname,headimg,add_time')->select();
        $arr=$cha;
        foreach ($arr as $key => &$va) {
            $arr[$key]['content']=json_decode($va['content']);
            $arr[$key]['images']=array_filter(explode(',',$va['images']));
            $arr[$key]['add_time'] = date('Y-m-d H:i',$va['add_time']);
            $qw = Db::name('forum_zan')->where(['threadid'=>$tid,'pinid'=>$arr[$key]['cid'],'userid'=>$dang,'pingid'=>$arr[$key]['uid']])->count();
            if (!$qw) {
                $arr[$key]['stat'] = 1;
            }else{
                $arr[$key]['stat'] = 0;
            }
            $va['hui'] = Db::name('forum_reply')->where(['comment_id'=>$arr[$key]['cid']])
                    ->field('id,comment_id,from_uid,to_uid,content as acontent,reply_status,fname,toname')
                    ->select();
            foreach ($va['hui'] as $key => &$v) {
                $va['hui'][$key]['acontent'] = json_decode($v['acontent']);
            }
        }
        show_api($arr);
    }
    //视频回复评论
    public function shihui()
    {
        $data = input('post.');
        $type = input('post.hui_status');//$type=1;
        $uid = input('post.shicomid');//视频id
        //$uid=240;
        $bei = input('post.shi_uid');//发布视频的用户id
        //$bei=50;
        $dang = input('post.hui_uid');//回复人id
        //$dang=59;
        $content = input('post.hcontent');//回复内容
        $nei = json_encode($content);
        $fu = Db::name('user')->where(['id'=>$bei])->field('id,name')->find();
        $to = Db::name('user')->where(['id'=>$dang])->field('id,name')->find();
        Db::name('forum_thread')->where(['id'=>$uid])->setInc('com_num');
        $data = Db::name('forum_shihui')->insert(['shicomid'=>$uid,'shi_uid'=>$bei,'hui_uid'=>$dang,'hcontent'=>$nei,'hui_status'=>$type,'shiname'=>$fu['name'],'huiname'=>$to['name']]);
        if ($data == 1) {
            $da = Db::name('forum_shihui')
                  ->where(['shi_uid'=>$bei])
                  ->field('id,shicomid,shi_uid,hui_uid,hcontent,hui_status,shiname,huiname')
                  ->find();
            $da['hcontent'] = json_decode($da['hcontent']);
            // $da['addtime'] = date('Y-m-d H:i',$da['addtime']);
            show_api($da,'回复成功');
            }elseif($data != 1){
                show_api($data,'回复失败',2);
            }
    }
    //删除回复
    public function shanhui()
    {
        $id = input('post.id');
        $da = Db::name('forum_shihui')->where(['id'=>$id])->find();
        Db::name('forum_thread')->where(['id'=>$da['shicomid']])->setDec('com_num');
        $data = Db::name('forum_shihui')->where(['id'=>$id])->delete();
        if ($data == 1) {
            show_api($data,'删除成功');
        }else{
            show_api($data,'删除失败',2);
        }
    }
    //点赞评论
    public function dianping(){
        $uid = input('post.userid');
        $pinid = input('post.pinid'); 
        $tid = input('post.threadid');
        $pid = input('post.pingid');
        $status = input('post.status');
        $data = Db::name('forum_zan')->where(['userid'=>$uid,'threadid'=>$tid,'pinid'=>$pinid,'pingid'=>$pid])->select();
        if (!$data) {
            $dian = Db::name('forum_zan')->insert(['userid'=>$uid,'threadid'=>$tid,'pinid'=>$pinid,'pingid'=>$pid,'status'=>$status]);
            $zang = Db::name('forum_comment')->where(['id'=>$pinid,'tid'=>$tid])->setInc('zan_num');
            $zan = Db::name('forum_comment')->where(['id'=>$pinid])->field('zan_num')->find();
            show_api($zan);
        }else{
            $zan = Db::name('forum_zan')->where(['userid'=>$uid,'pinid'=>$pinid,'threadid'=>$tid,'pingid'=>$pid,'status'=>0])->find();
            show_api($zan,'已点赞','1');
        }
    }
    //取消评论点赞
    public function qudian(){
        $uid = input('post.userid');
        $pinid = input('post.pinid');
        $tid = input('post.threadid');
        $pid = input('post.pingid');
        $status = input('post.status');
        $data = Db::name('forum_zan')->where(['userid'=>$uid,'threadid'=>$tid,'pinid'=>$pinid,'pingid'=>$pid])->find();
        // var_dump($data);die;
        if ($data != '') {
            $dian = Db::name('forum_zan')->where(['id'=>$data['id']])->delete();
            $shana = Db::name('forum_comment')->where(['id'=>$pinid,'tid'=>$tid])->setDec('zan_num');
            $shan = Db::name('forum_comment')->where(['id'=>$pinid,'tid'=>$tid])->field('zan_num')->find();
            // echo Db::table('forum_comment')->getLastSql();die;
            show_api($shan,'取消点赞');
        }else if($data == ''){
            show_api($data,'已取消点赞',2);
        }

    }
    
    // 点赞数量

    public function setNumerInc(){

        $result = false;

        $data = input('post.');

        if( $data['table'] == 'comment' ){

            $comment = DB::name('forum_comment')->where('id',$data['id'])->find();

            $comment['zan_user'] = explode(',',$comment['zan_user']);

            if( !in_array($this->user['id'],$comment['zan_user']) ){

                $comment['zan_user'][] = 1;

                $comment['zan_num']++;

                $result = DB::name('forum_comment')->where('id',$data['id'])->update([

                    'zan_num'=>$comment['zan_num'],

                    'zan_user'=>implode(',',$comment['zan_user'])

                ]);    

            }

        }else if( $data['table'] == 'thread' ){

            $thread = DB::name('forum_thread')->where('id',$data['id'])->find();

            $thread['zan_user'] = explode(',',$thread['zan_user']);

            if( !in_array($this->user['id'],$thread['zan_user']) ){

                $thread['zan_user'][] = 1;

                $thread['zan_num']++;

                $result = DB::name('forum_thread')->where('id',$data['id'])->update([

                    'zan_num'=>$thread['zan_num'],

                    'zan_user'=>implode(',',$thread['zan_user'])

                ]);

                $result && Db::name('thread_notice')->insert([

                    'tid'=>$thread['id'],

                    'uid'=>$this->user['id'],

                    'type'=>1,

                    'add_time'=>time()

                ]);

            }

        }

        show_api($result);

    }

}