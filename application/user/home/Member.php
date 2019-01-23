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
use think\Cookie;
/**
 *  会员控制器
 * @package app\forum\thread
 */
class Member extends Common
{
    //申请会员
    /**
     * @UId
     * @level 等级level
     */
    public function applyMember()
    {
        $data=input('post.');
//        $data['level']=1;
//        $data['uid']=138;
        $info=Db::name('user')->find($data['uid']);
        $ship=Db::name('user_ship')->where('level',$data['level'])->find();
        if($info['total_amount']>=$ship['condition'])
        {
            $update=[
                'level'=>$ship['level'],
                'discount'=>0
            ];
            Db::name('user')->where('id',$data['uid'])->update($update);
//            dump($ship);
            show_api('','恭喜你成为'.$ship['name'].'会员');
        }else{
            show_api('','你还没有达到条件',0);
        }
    }
    //获得会员列表
    public function getShip()
    {
        $data=Db::name('user_ship')->order('level asc')->select();
        show_api($data);
    }
}
