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
 * fenxiao控制器
 * @package app\forum\thread
 */

class Sale extends Common

{
    public function index()
    {
        $data = input('post.');
        $uid = input('post.uid');
        $de = Db::name('user')->where(['id'=>$uid])->field('headimg,name,yongID,leader,income,withdraw,sj_status')->find();
        if ($de['sj_status'] == 0) {
            show_api($de,'未绑定上级');
        }else if ($de['sj_status'] == 1) {
            show_api($de,'你已绑定上级');
        }
        if ($de['daren'] == 1) {
           show_api($de,'你是达人');
        }else if($de['daren'] == 2){
           show_api($de,'请申请',2);
        }else if ($de['daren'] == 3) {
           show_api($de,'审核中',3);
        }else if ($de['daren'] == 0) {
           show_api($de,'未申请',0);
       }
    }
    public function shen()
    {
        $daren = input('post.daren');
        $uid = input('post.uid');
        if ($daren == 2) {
            $sh=Db::name('user')->where(['id'=>$uid])->update(['daren'=>$daren]);
            $sq = Db::name('user')->where(['id'=>$uid,'daren'=>$daren])->find();
            show_api($sq,'待审核',2);
        }else if($daren == 0){
            $sh=Db::name('user')->where(['id'=>$uid])->update(['daren'=>$daren]);
            $sq = Db::name('user')->where(['id'=>$uid,'daren'=>$daren])->find();
            show_api($sq,'已取消申请',0);
        }
    }
    public function code()
    {
        $uid = input('post.uid');
        $code = rand(11111,99999);
        $yao = Db::name('user')->where(['id'=>$uid])->field('dangcode')->find();
        if (empty($yao['dangcode'])) {
            $data = Db::name('user')->where(['id'=>$uid])->update(['dangcode'=>$code]);
            $sd = Db::name('user')->where(['id'=>$uid])->field('dangcode')->find();
            show_api($sd);
        }else if(!empty($yao['dangcode'])){
            show_api($yao,'你已经生成邀请码了,不能再次生成',2);
        }
    }
    public function bang()
    {
        $uid = input('post.uid');//当前用户id
        // $uid = '76';
        $code = input('post.code');//上级用户邀请码
        // $code = '90759';
        $time = time();
        if(empty($code)){
            show_api('','请输入邀请码',2);
        }
        $us = Db::name('user')->where(['dangcode'=>$code])->field('id,dangcode')->find();
        if ($us['dangcode'] != $code) {
            show_api('','邀请码不正确',4);
        }
        if ($us['id'] == $uid) {
            show_api('','您不能绑定自己',3);
        }
        $data = Db::name('user')->where(['id'=>$uid])->update(['code'=>$code,'sj_status'=>1]);
        show_api($data,'绑定成功');
    }
    public function xiaji()
    {
        $uid = input('post.uid');
        $data = Db::name('user')->where(['leader'=>$uid])->field('id,name,headimg,bang_time')->select();
        foreach ($data as $key => $v) {
            $v['headimg'] = array_filter(explode(',',$v['headimg']));
            $v['bang_time'] = date('Y-m-d H:i',$v['bang_time']);
        }
        show_api($data);
    }
    public function yongjin()
    {
        $uid = input('post.uid');
        //$uid = 50;
        $shang = Db::name('user')->where(['leader'=>$uid])->field('id,leader')->select();
        foreach ($shang as $k => $v) {
            $asd = Db::name('shop_order')
                ->alias('a')
                ->join('user b','a.user_id = b.id')
                ->join('shop_goods g','a.goods_id = g.id')
                ->where(['a.user_id'=>$v['id']])
                ->field('a.order_sn,a.add_time,b.id,b.name,b.headimg,b.system,g.title,g.images')
                ->select();
            foreach ($asd as &$va) {
                $va['images'] = array_filter(explode(',',$va['images']));
                $va['add_time'] = date('Y-m-d H:i',$va['add_time']);
            }
        }
           show_api($asd);
    }
    public function tixian()
    {
        $data = input('post.');
        $uid = input('post.uid');
        $xian = input('post.withdraw');
        $sd = Db::name('user')->where(['id'=>$uid])->field('id,withdraw')->find();
        if ($xian > $sd['withdraw']) {
            show_api('','超过可提现金额',3);
        }elseif ($xian <= $sd['withdraw']) {
            if ($xian == '0.00') {
                show_api($xian,'提现金额不能为0',4);
            }
            $da = Db::name('user')->where(['id'=>$uid])->field('id,withdraw,wallet')->find();
            $ti = $da['withdraw'] - $xian;
            $xa = $da['wallet'] + $xian;
            $as = Db::name('user')->where(['id'=>$uid])->update(['withdraw'=>$ti,'wallet'=>$xa]);
            if ($as == 1) {
                show_api($as,'提现成功');
            }else if ($as != 1) {
                show_api($as,'提现失败',2);
            }
        }
    }
    public function autoWithdrawl()
    {
       $data=Db::name('user')
           ->whereTime('add_time','today')
           ->field('id,withdraw,wallet,add_time')
           ->select();
//       dump($data);
       foreach($data  as $k=>$v)
       {
           $update=[
               'add_time'=>$v['add_time']+3600*24*9,
               'wallet'=>$v['wallet']+$v['withdraw'],
               'withdraw'=>0,
           ];
            Db::name('user')->where('id',$v['id'])->update($update);
       }



    }
    //qianbao
    public function qianbao()
    {
        $uid = input('post.uid');
        $da = Db::name('user')->where(['id'=>$uid])->field('id,wallet')->find();
        show_api($da);
    }
}