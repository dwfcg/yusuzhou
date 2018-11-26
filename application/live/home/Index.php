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



namespace app\live\home;

use app\index\controller\Home;

use think\Db;

use think\Cookie;



/**

 * 直播首页控制器

 * @package app\forum\thread

 */
class Index extends Home
{
    /**
     * 首页
     * @author Zain
     */
    public function index()
    {
        $data = input('post.');
        $lives = Db::name('live_index')->where('status',1)
                ->where('videotype',1)
                ->order('id desc')
                ->field('id,cid,title,video,partake,column,v_list,img,details,uids,imgs,zan,niming,addtime,code,jifen,jfuids,listpic,is_tip,sort,status')
                ->limit(0,10)
                ->select();
        foreach ($lives as &$th) {
            $th['addtime'] = date('Y-m-d',$th['addtime']);
        }
        show_api($lives);
    }
    //新上视频
    // public function xin(){
    //     $data = input('post.');
    //     $data['status'] = array('eq',4);
    //     $live = Db::name('live_index')->where(['status'=>$data['status']])->limit(0,10)->order('id desc')->select();

    //     foreach ($live as &$th) {
    //         $th['addtime'] = date('Y-m-d',$th['addtime']);
    //     }
    //     show_api($live);
    // }



//------------------------------------------------------------

    //正在直播
    public function onair(){
        $data = Db::name('live_index')
                ->where('status',3)
                ->field('id,cid,title,video,partake,column,v_list,img,details,uids,imgs,zan,niming,addtime,code,jifen,jfuids,listpic,is_tip,sort,status,starttime,endtime')
                ->find();
        if (empty($data)) {
            show_api($data,'没有直播',0);
        }else{
            show_api($data);
        }

   }

//-------------------------------------------------------------
    //更多
    public function ajax_live(){

        $start = input('start');

        $lives = Db::name('live_index')->where('status',1)
                   ->order('id desc')
                   ->field('id,cid,title,video,partake,column,v_list,img,details,uids,imgs,zan,niming,addtime,code,jifen,jfuids,listpic,is_tip,sort,status')
                   ->limit($start,10)
                   ->select();

        $html = '';

        foreach($lives as $v){

            $html .= '<li>'.

            '<a href="'.url('index/live_index',array('lid'=>$v['id'])).'" class="link">'.

							'<div class="imgBox" style="background-image:url('.$v['img'].');">'.

							    '<div class="num"><span class="huifang">回放</span>'.$v['partake'].'人气</div>'.

								'<div class="info"></div>'.

							'</div>'.

							'<p class="f12"><span class="right">'.date('Y-m-d',$v['addtime']).'</span>'.$v['title'].'</p>'.

						'</a>'.

					'</li>'.

					'<div class="h2"></div>';

        }

        echo $html;
        exit;

    }

    // <iframe frameborder="0" width="640" height="498" src="https://v.qq.com/iframe/player.html?vid=p0537a29xn4&tiny=0&auto=0" allowfullscreen></iframe>
//-------------------------------------------------------------------------------------------
    //xin详情
    public function xq(){
        $lid = input('post.id');
        $user = json_decode(Cookie::get('userLogin',''),true);
        $data = Db::name('live_index')->field('id,cid,title,video,partake,column,v_list,img,details,uids,imgs,zan,niming,addtime,code,jifen,jfuids,listpic,is_tip,sort,status')->find($lid);
        // Db::name('live_index')->where('id',$lid)->setInc('partake');
        show_api($data);
    }
    //评论席
    public function pinglun(){
        $id = input('post.lid');
        $uid = input('post.userid');
        // $id = '18';$uid = '59';
        $user = json_decode(Cookie::get('userLogin',''),true);
        $arr = array();
        $data = Db::name('live_comment')->where(['lid'=>$id])
                   ->order('addtime desc')
                   ->field('id,lid,uid,headimg,username,tid,reply_ways,pid,parent_id,parent_uid,parent_name,contents,contents_t,zan,status,addtime')
                   ->select();
        $arr = $data;
        // print_r($arr);die;
        foreach ($arr as $key=>&$th) {
            $arr[$key]['contents'] = json_decode($th['contents']);
            $pl = Db::name('live_zan')->where(['userid'=>$uid,'liveid'=>$arr[$key]['lid'],'pinid'=>$arr[$key]['id'],'pingid'=>$arr[$key]['uid']])->find();
            // var_dump($pl);die;
            if(!$pl){
                $arr[$key]['sta'] = 1;
            }else{
                $arr[$key]['sta'] = 0;
            }
            $th['addtime'] = date('Y-m-d H:i:s',$th['addtime']);
        }

        show_api($arr);
    }
    //发送评论
    public function fasong(){
        $user = json_decode(Cookie::get('userLogin',''),true);
        $data['lid'] = input('post.lid');
        $data['uid'] = input('post.uid');
        $data['headimg'] = input('post.headimg');
        $data['username'] = input('post.username');
        $data['contents'] = input('post.contents');
        $data['contents'] = json_encode($data['contents']);
        $data['addtime'] = time();
        $data = Db::name('live_comment')->insertGetId($data);
        $result =Db::name('live_comment')->where('id',$data)->field('id,lid,uid,headimg,username,reply_ways,contents,zan,status,addtime')->select();
        foreach ($result as &$th) {
            $th['addtime'] = date('Y-m-d H:i:s',$th['addtime']);
        }

        show_api($result);

    }
//--------------------------------------------------------------------------------------
    //点赞视频
    public function dian(){
        $user = input('post.uid');
        $lid = input('post.liveid');//视频id
        $status = input('post.status');
        $data = ['userid'=>$user,'liveid'=>$lid,'status'=>$status];
        $shi = Db::name('live_shizan')->where($data)->select();
        if (!$shi) {
            $dian = Db::name('live_shizan')->insert($data);
            $zan = Db::name('live_index')->where(['id'=>$lid])->setInc('zan');
            $za = Db::name('live_index')->where(['id'=>$lid])->field('zan')->find();
            show_api($zan);
        }else{
            $zan = Db::name('live_shizan')->where(['userid'=>$user,'liveid'=>$lid])->find();
            show_api($zan,'已点赞',1);
        }
    }
    //取消视频点赞
    public function qushi(){
        $user = input('post.uid');
        $lid = input('post.liveid');
        $status = input('post.status');
        $data = ['userid'=>$user,'liveid'=>$lid];
        $shi = Db::name('live_zan')->where($data)->find();
        if ($shi != '') {
            $quxiao = Db::name('live_shizan')->where($data)->delete();
            $xiao = Db::name('live_index')->where(['id'=>$lid])->setDec('zan');
            $qu = Db::name('live_index')->where(['id'=>$lid])->field('zan')->find();
            show_api($quxiao,'取消点赞');
        }else if($shi == ''){
            show_api($qu,'已取消点赞',2);
        }
    }
    //点赞视频评论
    public function shiping(){
        $user = input('post.uid');//当前用户id
        $lid = input('post.liveid');//视频id
        $pingid = input('post.pingid');//评论视频的用户id
        $pinid = input('post.pinid');//评论id
        $status = input('post.status');
        $data = Db::name('live_zan')->where(['userid'=>$user,'liveid'=>$lid,'pinid'=>$pinid,'pingid'=>$pingid])->select();
        if (!$data) {
            $data = Db::name('live_zan')->insert(['userid'=>$user,'liveid'=>$lid,'pinid'=>$pinid,'pingid'=>$pingid,'status'=>$status]);
            $zang =Db::name('live_comment')->where(['id'=>$pinid,'lid'=>$lid,'uid'=>$pingid])->setInc('zan');
            $zan =Db::name('live_comment')->where(['id'=>$pinid,'lid'=>$lid,'uid'=>$pingid])->field('zan')->find();
            show_api($zan);
        }else{
            $dian = Db::name('live_zan')->where(['userid'=>$user,'liveid'=>$lid,'pinid'=>$pinid,'pingid'=>$pingid,'status'=>0])->find();
            show_api($dian,'已点赞',1);
        }
    }
    //取消点赞视频评论
    public function cancel(){
        $user = input('post.uid');//当前用户id
        $lid = input('post.liveid');//视频id
        $pingid = input('post.pingid');//评论视频的用户id
        $pinid = input('post.pinid');//评论id
        $status = input('post.status');
        $data = Db::name('live_zan')->where(['userid'=>$user,'liveid'=>$lid,'pinid'=>$pinid,'pingid'=>$pingid])->find();
        $quxiao = Db::name('live_zan')->where(['userid'=>$user,'liveid'=>$lid,'pinid'=>$pinid,'pingid'=>$pingid])->delete();
        $xiao=Db::name('live_comment')->where(['id'=>$pinid,'lid'=>$lid,'uid'=>$pingid])->setDec('zan');
        $zan = Db::name('live_comment')->where(['id'=>$pinid,'lid'=>$lid,'uid'=>$pingid])->field('zan')->find();
        show_api($zan);            


    }

//----------------之前-------------------------------------------
    /**

     * 详情

     */
    public function live()
    {
        $lid = input('lid');$lid=17;
        $user = json_decode(Cookie::get('userLogin',''),true);
        Db::name('live_index')->where('id',$lid)->setInc('partake');
        $live = Db::name('live_index')->field('id,cid,title,video,partake,column,v_list,img,details,uids,imgs,zan,niming,addtime,code,jifen,jfuids,listpic,is_tip,sort,status,starttime,endtime')->find($lid);
        if ($live['partake'] > 10000) 
        {
            $live['partake'] = round($live['partake'] / 10000, 2) . 'w';
        }
        if ($live['zan'] >= 10000) 
        {
            $live['zan'] = round($live['zan'] / 10000, 2) . 'w';
        }
        $where['lid'] = $lid;
        $where['pid'] = 0;
        $count = Db::name('live_comment')->where($where)->count();
        //向上舍入为最接近的整数并返回一个最大值
        $pagec = max(1, ceil($count / 10));
        $comments = Db::name('live_comment')->where($where)->order('id desc')->limit(0,10)->select();
        foreach ($comments as &$rowc) {
            $rowc['my_zan'] = '';
            if ($rowc['zan']) {
                $zans = explode(',', $rowc['zan']);
                $rowc['zan'] = count(explode(",", $rowc['zan']));
                foreach ($zans as $val) {
                    $array[$val] = $val;
                }
                $rowc['my_zan'] = '';
                if(isset($user)){
                   if (isset($array[$user['id']])) {
                        $rowc['my_zan'] = 'thzan';
                    }
                }
            } else {
                $rowc['zan'] = 0;
            }
            if ($rowc['jinghua'] == 1) {
                $rowc['place'] = 'topic';
            }
            // var_dump($comments);die;
            $wheres['pid'] = $rowc['id'];
            $wheres['lid'] = $rowc['lid'];
            $rowc['coms'] = Db::name('live_comment')->where($wheres)->order('id desc')->limit(0,4)->select();
            var_dump($rowc['coms']);
            $count = Db::name('live_comment')->where($wheres)->count();
            $num = $count - 4;
            $rowc['coms_num'] = 0;
            if ($num > 0) {
                $rowc['coms_num'] = $num;
            }
            $rowc['addtime1'] = dgmdate($rowc['addtime']);
        }
        die;
        $this->assign('pagec',$pagec);  
        $this->assign('comments',$comments);
        $this->assign('uid',$user['id']);
        $this->assign('live',$live);
        return $this->fetch();

    }

    //点心 

    public function ajax_zan()
    {
        $lid = input('lid');
        $sign = input('sign');
        if ($sign == 'reply') {
            $uid = input('uid');
            $comment = Db::name('live_comment')->find($lid);
            if (!$uid) {
                $res['status'] = 2;
                $res['url'] = '';
                echo json_encode($res);
                exit;
            }
            $array = array();
            if($comment['zan']){
                $zans = explode(',', $comment['zan']);
                foreach ($zans as $row) {
                    $array[$row] = $row;
                }
            }
            if(isset($array[$uid])) {
                if ($comment['zan']) {
                    $one = strpos($comment['zan'], ',');
                    if ($one) {
                        $where['zan'] = str_replace(',' . $uid, '', $comment['zan']);
                    } else {
                        $where['zan'] = str_replace($uid, '', $comment['zan']);
                    }
                } else {
                    $where['zan'] = 0;
                }
            } else {
                if ($comment['zan']) {
                    $where['zan'] = $comment['zan'] . "," . $uid;
                } else {
                    $where['zan'] = $uid;
                }
            }
            $result = Db::name('live_comment')->where('id',$lid)->update($where);
            if ($result) {
                $res['status'] = 1;
                if (!$where['zan']) {
                    $res['change'] = 0;
                } else {
                    $res['change'] = count(explode(",", $where['zan']));
                }
                echo json_encode($res);
                exit;
            }
        }else{
            Db::name('live_index')->where('id',$lid)->setInc('zan');
            $live = Db::name('live_index')->find($lid);
            if ($live) {
                $res['msg'] = $live['zan'];
                echo json_encode($res);
                exit;
            }
        }
        $res['status'] = '';
        echo json_encode($res);

    }

    //评论  

    public function morerepies(){

        $user = json_decode(Cookie::get('userLogin',''),true);

        $page =   input('page');

        $page = $page * 10;

        $lid =   input('lid');

        $where['lid'] = $lid;

        $where['pid'] = 0;

        $live = Db::name('live_index')->find($lid);
        //查询评论数
        $count = Db::name('live_comment')->where($where)->count();
        //向上舍入为最接近的整数并返回一个最大值
        $pagec = max(1, ceil($count / 10));
        $list_c = Db::name('live_comment')->where($where)->order('id desc')->limit($page,10)->select();
        foreach ($list_c as &$rowc) {
            if ($rowc['zan']) {
                $zans = explode(',', $rowc['zan']);
                $rowc['zan'] = count(explode(",", $rowc['zan']));
                foreach ($zans as $val) {
                    $array[$val] = $val;
                }
                $rowc['my_zan'] = '';
                if(isset($user)){
                   if ($array[$user['id']]) {
                        $rowc['my_zan'] = 'thzan';
                    }
                }
            } else {
                $rowc['zan'] = 0;
            }
            if ($rowc['jinghua'] == 1) {
                $rowc['place'] = 'topic';
            }
            $wheres['pid'] = $rowc['id'];
            $wheres['lid'] = $rowc['lid'];
            $rowc['coms'] = Db::name('live_comment')->where($wheres)->order('id desc')->limit(0,4)->select();
            $count = Db::name('live_comment')->where($wheres)->count();
            $num = $count - 4;
            if ($num > 0) {
                $rowc['coms_num'] = $num;
            }
            $rowc['username'] = $rowc['username'];
            $rowc['contents'] = $rowc['contents'];
            $rowc['contents_t'] = $rowc['contents_t'];
            $rowc['parent_name'] = $rowc['parent_name'];
            $rowc['addtime'] = dgmdate($rowc['addtime']);
        }
        $res['pagec'] = $pagec;
        $res['html'] = $list_c;
        echo json_encode($res);
    }

    //回复
    public function reply()
    {
        $lid = input('lid');
        $parent_id = input('parent_id');
        $parent_uid = input('parent_uid');
        $parent_name = input('parent_name'); 
        $contents = input('contents'); 
        $reply_ways = input('reply_ways'); 
        $comment =  Db::name('live_comment')->find($parent_id);
        $uid = input('uid');
        $user = Db::name('user')->find($uid);
        if (!$uid) {
            $res['status'] = 2;
            $res['url'] =  '';
            echo json_encode($res);
            exit;
        }
        $data['uid'] = $uid;
        if ($reply_ways) {
            $data['username'] = '匿名用户';
        } else {
            $data['username'] = $user['name'];
            $data['headimg'] = $user['headimg'];
        }
        $data['reply_ways'] = $reply_ways;
        $data['lid'] = $lid;
        if ($comment['pid']) {
            $data['pid'] = $comment['pid'];
        } else {
            $data['pid'] = $comment['parent_id'];
        }
        $data['parent_id'] = $parent_id;
        $data['parent_uid'] = $parent_uid;
        $data['parent_name'] = $parent_name;
        $data['contents'] = $contents;
        $data['addtime'] = time();
        $result = Db::name('live_comment')->insert($data);
        if ($result) {
            $res['status'] = 1;
            $res['parent_username'] = $data['username'];
            $res['reply_username'] = $data['parent_name'];
            $res['content'] = $data['contents'];
            if ($data['pid']) {
                $res['pid'] = $data['pid'];
            } else {
                $res['pid'] = $data['parent_id'];
            }
            $res['parent_id'] = $result;
            $res['parent_uid'] = $data['uid'];
            $res['status'] = 1;
            $res['pl_username'] = $data['username'];
            $res['pl_time_advance'] = dgmdate($data['addtime']);
            $res['pl_content'] = $data['contents'];
            $res['topic_content'] = '';
            $res['pl_id'] = $result;
            $res['pl_uid'] = $data['uid'];
            $res['pl_avatar'] = $data['headimg'];
            $res['pl_time'] = $data['addtime'];
            echo json_encode($res);
            exit;
        }
        $res['status'] = 0;
        $res['msg'] = '网络错误';
        echo json_encode($res);

    }

    // 检测新消息

    public function newreplies(){

        $lid = input('lid');

        $lasttime = input('lasttime');

        $where['lid'] = $lid;

        $where['pid'] = 0;

        $where['addtime'] = array('gt',$lasttime);

        $count = Db::name('live_comment')->where($where)->count();

        if ($count > 0) {

            $res['status'] = 1;

            echo json_encode($res);

        } else {

            $res['status']  = '';

            echo json_encode($res);
        }

        exit;

    }

    //获取新消息

    public function getnewreplies(){

        $lid = input('lid');

        $lasttime = input('lasttime');

        $where['lid'] = $lid;

        $where['pid'] = 0;

        $where['addtime'] = array('gt',$lasttime);

        $user = json_decode(Cookie::get('userLogin',''),true);

        $list_c = Db::name('live_comment')->where($where)->order('id desc')->select();

        foreach ($list_c as &$rowc) {

            $rowc['my_zan'] = '';

            if ($rowc['zan']) {

                $zans = explode(',', $rowc['zan']);

                $rowc['zan'] = count(explode(",", $rowc['zan']));

                foreach ($zans as $val) {

                    $array[$val] = $val;

                }

                $rowc['my_zan'] = '';

                if(isset($user)){

                   if ($array[$user['id']]) {

                        $rowc['my_zan'] = 'thzan';

                    }  

                }

            } else {

                $rowc['zan'] = 0;

            }

            if ($rowc['jinghua'] == 1) {

                $rowc['place'] = 'topic';

            }

            $wheres['pid'] = $rowc['id'];

            $wheres['lid'] = $rowc['lid'];

            $rowc['coms'] = Db::name('live_comment')->where($wheres)->order('id desc')->limit(0,4)->select();

            $count = Db::name('live_comment')->where($wheres)->count();

            $num = $count - 4;

            if ($num > 0) {

                $rowc['coms_num'] = $num;

            }

            $rowc['username'] = $rowc['username'];

            $rowc['contents'] = $rowc['contents'];

            $rowc['contents_t'] = $rowc['contents_t'];

            $rowc['parent_name'] = $rowc['parent_name'];

            $rowc['addtime1'] = dgmdate($rowc['addtime']);

        }

        $res['html'] = $list_c;

        echo json_encode($res);

    }

}