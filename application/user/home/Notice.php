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



namespace app\user\home;

use think\Db;

use think\Session;

use think\Cookie;

/**

 * 前台首页控制器

 * @package app\forum\thread

 */

class Notice extends Common

{

    public $user;

    protected function _initialize()

    {

        $user = json_decode(Cookie::get('userLogin',''),true);

        if( is_array($user) ){

            $this->user = $user;

        }

    }

    

    public function notice_nums(){

        $data['system'] = Db::name('system_notice')->whereNotLike('read_uid','%,'.$this->user['id'].',%')->count();

        $data['zan'] = Db::name('thread_notice')->where(['uid'=>$this->user['id'],'type'=>1,'status'=>0])->count();

        $data['com'] = Db::name('thread_notice')->where(['uid'=>$this->user['id'],'type'=>2,'status'=>0])->count();

        show_api($data);

    }

    

    //系统通知

    public function notice_list(){

        $data = input('post.');

        if( $data['type'] == 'system' ){

            $notices = Db::name('system_notice')->select();

            foreach( $notices as $n ){

                if( strpos($n['read_uid'],','.$data['uid'].',') === false ){

                    Db::name('system_notice')->where(['id'=>$n['id']])->update(['read_uid'=>$n['read_uid'].','.$data['uid'].',']);

                }

            }

        }

        if( $data['type'] == 'zan' ){

            Db::name('thread_notice')->where(['uid'=>$data['uid'],'type'=>1])->update(['status'=>1]);

            $notices = Db::name('thread_notice')->alias('n')->join('forum_thread t','n.tid = t.id')->where(['n.uid'=>$data['uid'],'n.type'=>1])->field('n.*,t.title,t.images')->select();

        }

        if( $data['type'] == 'com' ){

            Db::name('thread_notice')->where(['uid'=>$data['uid'],'type'=>2])->update(['status'=>1]);

            $notices = Db::name('thread_notice')->alias('n')->join('forum_thread t','n.tid = t.id')->where(['n.uid'=>$data['uid'],'n.type'=>2])->field('n.*,t.title,t.images')->select();

        } 

        foreach( $notices as &$n ){

            if( isset($n['tid']) ){

                $n['intro'] = $n['type'] == 1 ? '收到一个点赞' : '收到一个评论';

                $n['url'] = url('forum/detail/index',array('id'=>$n['tid']),'html',true);

                $n['image'] = current(explode(',',$n['images']));

            }

            $n['add_time'] = formatTime($n['add_time']);

        }

        show_api($notices);

    }

}