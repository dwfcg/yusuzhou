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

namespace app\auction\home;

use app\index\controller\Home;

use think\Db;

use think\Cookie;
use Wxpay\Wxpay;
/**
 * 拍卖首页控制器
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
        $goods = Db::name('auction_goods')->where(['status'=>array('neq',3)])->field('id,title,imgs,start_price,price,price_range,content,start_time,end_time,partake,status,bands,addtime')
                ->order('addtime desc')->select();
        foreach($goods as &$row)
        {
            $row['imgs'] = explode(',',$row['imgs']);
            $row['addtime']=date('Y-m-d H:i',$row['addtime']);
        }
        show_api($goods);
    }

    //即将开始0
    public function jijiang()
    {
        $goods = Db::name('auction_goods')->where(['status'=>0])
                ->field('id,title,imgs,start_price,price,price_range,content,start_time,end_time,partake,status,bands,addtime')
                ->order('id desc')->select();
            foreach ($goods as &$v) {
                $v['imgs'] = array_filter(explode(',',$v['imgs']));
                $v['addtime'] = date('Y-m-d H:i',$v['addtime']);
            }
        show_api($goods);
    }
    //已结束3
    public function jieshu()
    {
        $goods = Db::name('auction_goods')->where(['status'=>3])->field('id,title,imgs,start_price,price,price_range,content,start_time,end_time,partake,status,bands,addtime')
                ->limit(0,10)->order('id desc')->select();
        foreach ($goods as &$v) {
            $v['imgs'] = array_filter(explode(',',$v['imgs']));
            $v['addtime'] = date('Y-m-d H:i',$v['addtime']);
        }
        show_api($goods);
    }
    /**
     * 保证金
     */ 
    public function bond()
    {
        $config = Db::name('auction_config')->find(1);
        $config['rule'] = explode("\r\n",$config['rule']);
        $array = array();
        foreach($config['rule'] as $v){
            list($a,$b) = explode("=",$v);
            $array[$a] = $b;
        }
        $user = json_decode(Cookie::get('userLogin',''),true);
        $config['rule'] = $array;
        $this->assign('config',$config);
        $this->assign('user',$user);
        return $this->fetch();
    }
    /**
     * 添加保证金
    */
    public function ajax_bzj()
    {
        $user = json_decode(Cookie::get('userLogin',''),true);
        if(!$user){
            $this->error('请先登录');
        }
        $money = input('money');
        $config = Db::name('auction_config')->find(1);
        $config['rule'] = explode("\r\n",$config['rule']);
        $array = array();
        foreach($config['rule'] as $v){
            list($a,$b) = explode("=",$v);
            $array[$a] = $b;
        }
        Db::name('user')->where('id',$user['id'])->setInc('bond',$money);
        Db::name('user')->where('id',$user['id'])->setInc('bond_price',$array[$money]);
        $this->success('充值成功');
    }
    //新交保证金
    public function bzj()
    {
        $uid = input('post.uid');//$uid = 77;
        $gid = input('post.gid');//$gid = 1;
        $band = input('post.band'); //$band = 200;
        $order_no = date('YmdHis').rand(11111,99999);
        $data = Db::name('auction_band')->where(['uid'=>$uid,'gid'=>$gid,'band'=>$band,'status'=>0])->find();
        if ($data != '') {
            show_api($data,'请付保证金',2);
        }else if ($data == '') {
            $cha = Db::name('auction_band')->insert(['uid'=>$uid,'gid'=>$gid,'band'=>$band,'order_no'=>$order_no,'status'=>0,'addtime'=>time()]);
            $da = Db::name('auction_band')->where(['uid'=>$uid,'gid'=>$gid,'band'=>$band])->find();
            show_api($da);
        }
    }
    /**
     * 详情
     */
    public function detail()
    {
        $gid = input('post.gid');//$gid = 1;
        $uid = input('post.uid');//$uid =2;
//        dump($uid);
        Db::name('auction_goods')->where('id',$gid)->setInc('partake');
        if ($uid == '') {
            $goods = Db::name('auction_band')
                ->where(['uid'=>$uid,'gid'=>$gid])
                ->field('status')->find();
//            var_dump($goods);die;
            if ($goods['status'] == 0) {
                $goods = Db::name('auction_goods')
                    ->where(['id'=>$gid])
                    ->field('id,title,imgs,start_price,price,price_range,content,start_time,end_time,partake,status,bands,addtime')
                    ->find();
                $goods['imgs'] = array_filter(explode(',',$goods['imgs']));
                $goods['addtime'] = date('Y-m-d H:i',$goods['addtime']);
                $goods['jilu'] = Db::name('auction_record')->alias('a')
                        ->join('user u','a.userid=u.id')
                        ->where(['goodid'=>$gid])
                        ->field('a.goodid,a.money,a.datetime,a.states,a.success,a.type,u.id,u.name,u.headimg')
                        ->order('money desc,datetime desc')
                        ->limit(0,3)
                        ->select();
                foreach ($goods['jilu'] as &$va) {
                    $va['datetime'] = date('m-d H:i:s',$va['datetime']);
                }
                $goods['tixing'] = Db::name('auction_tixing')->where(['gid'=>$gid,'uid'=>$uid])->count();
                $goods['zongshu'] = Db::name('auction_record')->where(['goodid'=>$gid])->count();
                show_api($goods,'未登录状态',3);
            }
        }else if (!empty($uid)) {
            $goods = Db::name('auction_band')->where(['uid'=>$uid,'gid'=>$gid])->field('status')->find();
//            dump($goods['status']);die();
            if ($goods['status'] == 0) {
                $goods = Db::name('auction_goods')->where(['id'=>$gid])->field('id,title,imgs,start_price,price,price_range,content,start_time,end_time,partake,status,bands,addtime')
                    ->find();
                $goods['imgs'] = array_filter(explode(',',$goods['imgs']));
                $goods['addtime'] = date('Y-m-d H:i',$goods['addtime']);
                $goods['jilu'] = Db::name('auction_record')->alias('a')
                        ->join('user u','a.userid=u.id')
                        ->where(['goodid'=>$gid])
                        ->field('a.goodid,a.money,a.datetime,a.states,a.success,a.type,u.id,u.name,u.headimg')
                        ->order('money desc,datetime desc')
                        ->limit(0,3)
                        ->select();
                foreach ($goods['jilu'] as &$va) {
                    $va['datetime'] = date('m-d H:i:s',$va['datetime']);
                }
                $goods['tixing'] = Db::name('auction_tixing')->where(['gid'=>$gid,'uid'=>$uid])->count();
                $goods['zongshu'] = Db::name('auction_record')->where(['goodid'=>$gid])->count();
                show_api($goods,'未缴纳保证金',2);
            }else if ($goods['status'] == 1) {
                $goods = Db::name('auction_goods')
                    ->where(['id'=>$gid])
                    ->field('id,title,imgs,start_price,price,price_range,content,start_time,end_time,partake,status,bands,addtime')
                    ->find();
//                dump($goods);die();
                $goods['imgs'] = array_filter(explode(',',$goods['imgs']));
                $goods['addtime'] = date('Y-m-d H:i',$goods['addtime']);
                $goods['jilu'] = Db::name('auction_record')->alias('a')
                        ->join('user u','a.userid=u.id')
                        ->where(['goodid'=>$gid])
                        ->field('a.goodid,a.money,a.datetime,a.states,a.success,a.type,u.id,u.name,u.headimg')
                        ->order('money desc,datetime desc')
                        ->limit(0,3)
                        ->select();
                foreach ($goods['jilu'] as &$va) {
                    $va['datetime'] = date('m-d H:i:s',$va['datetime']);
                }
                $goods['tixing'] = Db::name('auction_tixing')->where(['gid'=>$gid,'uid'=>$uid])->count();
                $goods['zongshu'] = Db::name('auction_record')->where(['goodid'=>$gid])->count();
                show_api($goods,'已缴纳保证金',1);
                }
            }
        }
    //设置提醒
    public function tixing()
    {
         $gid = input('post.gid');
         $uid = input('post.uid');
         $tixing = input('post.tixing');
         $time = time();
         $data = Db::name('auction_tixing')->where(['gid'=>$gid,'uid'=>$uid])->find();
         if (!$data) {
             $data = Db::name('auction_tixing')->insert(['gid'=>$gid,'uid'=>$uid,'tixing'=>$tixing,'addtime'=>$time]);
             show_api($data,'设置提醒');
         }elseif ($data) {
             $data = Db::name('auction_tixing')->where(['gid'=>$gid,'uid'=>$uid,'tixing'=>$tixing])->find();
             show_api($data,'已设置提醒',2);
         }
    }
    //取消提醒
    public function quxing()
    {
         $gid = input('post.gid');
         $uid = input('post.uid');
         $tixing = input('post.tixing');
         $time = time();
         $data = Db::name('auction_tixing')->where(['gid'=>$gid,'uid'=>$uid])->find();
         if ($data != '') {
             $data = Db::name('auction_tixing')->where(['id'=>$data['id']])->delete();
             show_api($data,'取消提醒');
         }elseif ($data == '') {
             show_api($data,'已取消提醒',2);
         }
    }
    //出价记录
    public function jilu()
    {
        $data = input('post.');
        $gid = input('post.gid');
        $page = 10;
        $data = Db::name('auction_record')->alias('a')
                    ->join('user u','a.userid=u.id')
                    ->where(['a.goodid'=>$gid])
                    ->field('a.goodid,a.money,a.datetime,a.states,a.success,a.type,u.id,u.name,u.headimg')
                    ->order('money desc,datetime desc')
                    ->limit($data['page']*$page,$page)
                    ->select();
        foreach ($data as &$va) {
            $va['datetime'] = date('m-d H:i:s',$va['datetime']);
        }
        show_api($data);
    }
    //出价xin
    public function chujia()
    {
        $gid = input('goodid');//$gid=1;
        $re=Db::name('auction_goods')->find($gid);
        if(!$re['status']==3)
        {
            show_api('','已经结束拍卖',0);
        }
        $money = input('money');//$money='100';
        $uid = input('userid');//$uid = 3;
        if ($uid == '') {
            show_api($uid,'请先登录',2);
        }else if($uid != ''){
            $sd = Db::name('auction_record')->where(['goodid'=>$gid,'type'=>1])->field('userid,money')->find();
            $jia = $money+$sd['money'];
            //var_dump($jia);die;
            if ($jia>$sd['money']) {
                Db::name('auction_record')->where(['goodid'=>$gid,'userid'=>$sd['userid']])->update(['type'=>0]);
                $data['goodid'] = $gid;
                $data['userid'] = $uid;
                $data['money'] = $jia;
                $data['datetime'] = time();
                $data['type'] = 1;
                Db::name('auction_record')->insert($data);
               $as = Db::name('auction_goods')->where('id',$gid)->update(['price'=>$jia]);
//               echo Db::name('auction_goods')->getLastSql();die;
                Db::name('auction_goods')->where('id',$gid)->setInc('offer');
                $da = Db::name('auction_record')->alias('a')
                      ->join('user b','a.userid=b.id')
                      ->where(['a.userid'=>$data['userid'],'a.type'=>1])
                      ->field('a.id,a.goodid,a.userid,a.money,a.datetime,a.states,a.success,a.type,b.name,b.headimg')
                      ->order('a.id desc')
                      ->find();
                $da['datetime'] = date('m-d H:i:s',$da['datetime']);
                show_api($da,'出价成功');
            }elseif ($jia<=$sd['money']) {
                show_api($jia,'重新出价',2);
            }
        }
    }
    //拍卖结束
    public function tuibao()
    {
        $gid = input('post.gid');
        $status = input('post.status');
        $data = Db::name('auction_goods')->where(['id'=>$gid])->update(['status'=>3]);
        Db::name('auction_record')->where(['goodid'=>$gid])->update(['states'=>1]);
        Db::name('auction_record')->where(['goodid'=>$gid,'type'=>1])->update(['success'=>1]);
        $bao = Db::name('auction_goods')->where(['id'=>$gid])->field('id,price,status')->find();
        $record = Db::name('auction_record')->where(['goodid'=>$gid,'type'=>1])->field('id,userid')->find();
        if ($bao['status'] == '3') {
            $order_sn = date('YmdHis').rand(11111,99999);
            $time = time();
            $order = Db::name('auction_order')->insert(['order_sn'=>$order_sn,'gid'=>$bao['id'],'uid'=>$record['userid'],'price'=>$bao['price'],'add_time'=>$time]);
            $da = Db::name('auction_order')->where(['uid'=>$record['userid'],'gid'=>$bao['id'],'price'=>$bao['price']])->find();
            if ($da != '') {
                show_api($da,'生成订单成功');
            }elseif ($da == '') {
                show_api($da,'生成订单失败',2);
            }
        }else if ($bao['status'] == '2') {
            $data = Db::name('auction_goods')->where(['id'=>$gid])->update(['status'=>2]);
            $da = Db::name('auction_goods')->where(['id'=>$gid])->find();
            show_api($da,'该商品流拍',2);
        }
    }
    //查未拍得商品人数
    public function weipai()
    {
        $gid = input('post.gid');
        $data = Db::name('auction_record')->where(['goodid'=>$gid,'states'=>1,'type'=>0])->select();
        
    }
    public function ding(){
        $ding = Db::name('auction_goods')->where(['status'=>0])->select();
        $time = date('Y-m-d H:i:s',time());
        foreach ($ding as $key => $v) {
            if(strtotime($time)>=strtotime($v['start_time'])){
                $as = Db::name('auction_goods')->where(['id'=>$v['id']])->update(['status'=>1]);
            }
        }
    }
    public function jie()
    {
        $time = date('Y-m-d H:i:s',time());
        dump($time);
        $ding = Db::name('auction_goods')->where(['status'=>1,'end_time'=>['lt',$time]])->select();
        dump($ding);
        if (empty($ding)){
            exit;
        }else{
            foreach ($ding as $key => $v) {
                // if(strtotime($time)>=strtotime($v['end_time'])){
                // }
            }
            $arr = array_column($ding, 'id');
//            dump($arr);

            $jie = Db::name('auction_goods')->where(['id'=>['in',$arr]])->update(['status'=>3]);
            Db::name('auction_record')->where(['goodid'=>['in',$arr]])->update(['states'=>1]);
            $da = Db::name('auction_record')->where(['goodid'=>['in',$arr],'type'=>1])->update(['success'=>1]);
            foreach ($arr as $k =>$v)
            {
                $na = Db::name('auction_record')->where(['success'=>1,'states'=>1,'type'=>1,'goodid'=>$v])->find();
                $this->refund($data['goodid']=$na['goodid']);
                $data['userid']=$na['userid'];
                $this->makeOrder($data);
            }
//
            $order_sn = date('YmdHis').rand(11111,99999);
            $time = time();
//            $order = Db::name('auction_order')->insert(['order_sn'=>$order_sn,'gid'=>$na['goodid'],'uid'=>$na['userid'],'price'=>$na['money'],'add_time'=>$time]);
//            $daa = Db::name('auction_order')->where(['uid'=>$na['userid'],'gid'=>$na['goodid'],'price'=>$na['money']])->find();
//            if ($daa != '') {
//                show_api($daa,'生成订单成功');
//            }elseif ($daa == '') {
//                show_api($daa,'生成订单失败',2);
//            }
      }
    }
    public function makeOrder($data)
    {
//        $data=input('post.');
        $address=Db::name('address')->where('user_id',$data['userid'])->where('default',1)->find();
        $where=[
            'success'=>1,
            'states'=>1,
            'type'=>1,
            'goodid'=>$data['goodid'],
            'userid'=>$data['userid']
        ];
        $na = Db::name('auction_record')->where($where)->find();
//        dump($na);
        $order_sn = date('YmdHis').rand(11111,99999);
        $time = time();
        $insertData=[
            'order_sn'=>$order_sn,
            'goods_id'=>$na['goodid'],
            'user_id'=>$na['userid'],
            'price'=>$na['money'],
            'address_id'=>$address['address_id'],
            'order_status'=>3,
            'add_time'=>$time
        ];
        $order = Db::name('shop_order')->insert($insertData);
        //退还保证金

        $return=[
            'userid'=>$data['userid'],
            'order_sn'=>$order_sn,
        ];
//        dump($return);
        show_api($return);


    }
    public function refund($data)
    {
//        $data=input('post.');
        $where1=[
            'gid'=>$data['goodid'],
            'status'=>1,
        ];
        $refundData=Db::name('auction_band')->where($where1)->select();
//        dump($refundData);
        $arr=array_column($refundData,'id');
        Db::name('auction_band')->where(['id'=>['in',$arr]])->update(['status'=>2]);
        foreach ($refundData as $k =>$v)
        {
            $refundOrder=[
                'trade_no'=>$v['trade_no'],
                'price'=>$v['band'],
            ];
            if($v['pay_type']==3)
            {
                Db::name('user')->where('id',$v['uid'])->setInc('wallet',$v['band']);
            }elseif ($v['pay_type']==2)
            {
                $this->weixinRefund($refundOrder);
            }

        }
        show_api();
    }
    public function weixinRefund($refundOrder)
    {
        $params = [
            'appid'   =>  'wx0578b9d04b418614', //APPID
            'mch_id'  => '1493283802', //商户号
//            'key'  => 'n0alu1cnrq8bdus6jcpnnhkig421suz6', //商户号
            'nonce_str'=> md5(time()), //随机串
            'sign'  => 'md5',          //签名方式
            'out_refund_no'  => time(),          //签名方式
            'transaction_id'=> $refundOrder['trade_no'],//微信支付订单号 与商户订单号二选一
//            'transaction_id'=> '4200000220201810298990235763',//微信支付订单号 与商户订单号二选一
            'total_fee'=>$refundOrder['price']*100,
            'refund_fee'=>$refundOrder['price']*100,
//            'notify_url'=>'http://yusuzhou.youacloud.com/index.php/shop/refund/refund_notify_url'
        ];
        $signParams = $this->setSign($params);
        $xmlData = $this->ArrToXml($signParams);
        //发送请求
        $class=new Wxpay($params);
        $url='https://api.mch.weixin.qq.com/secapi/pay/refund';
        $re=$class->postXmlCurl($xmlData,$url,'true');
//        dump($re);
        libxml_disable_entity_loader(true);
        $xmlArray = json_decode(json_encode(simplexml_load_string($re, 'SimpleXMLElement', LIBXML_NOCDATA)), true);//xml数据转换成array 转换形式良好的XML字符串为 SimpleXMLElement对象。
        //接受xml数据流结束
        $fileName = 'a.txt';
        $postData = var_export($xmlArray, true);
        $file     = fopen('' . $fileName, "a+");
        fwrite($file,$postData);
        fclose($file);
        //php写一个日志文件
        //$xml可以理解为微信服务器返回给我们标准的php数组
        //支付成功
//        dump($xmlArray);
        if ($xmlArray['result_code'] == "SUCCESS") {
            $out_trade_no = $xmlArray['out_trade_no'];//订单号：业务逻辑区域
            $order_info = Db::name("auction_band")->where("order_sn='{$out_trade_no}'")->select();
             Db::name("auction_band")->where("gid='{$order_info['gid']}'")->delete();

            //没有同步本地服务器数据
        } else {
//            echo "FAIL";
//            return  $this->error('微信未处理成功');
            exit;
        }
    }
    //获取签名
    public function getSign($arr){
        //去除数组的空值
        array_filter($arr);
        if(isset($arr['sign'])){
            unset($arr['sign']);
        }
        //排序
        ksort($arr);
        //组装字符
        $str = $this->arrToUrl($arr) . '&key=' .'n0alu1cnrq8bdus6jcpnnhkig421suz6';
        //使用md5 加密 转换成大写
        return strtoupper(md5($str));
    }
    //获取带签名的数组
    public function setSign($arr){
        $arr['sign'] = $this->getSign($arr);
        return $arr;
    }
    //校验签名
    public function checkSign($arr){
        //生成新签名
        $sign = $this->getSign($arr);
        //和数组中原始签名比较
        if($sign == $arr['sign']){
            return true;
        }else{
            return false;
        }
    }
    //数组转URL字符串 不带key
    public function arrToUrl($arr){
        return urldecode(http_build_query($arr));
    }
    //记录到文件
    public  function logs($file,$data){
        $data = is_array($data) ? print_r($data,true) : $data;
        file_put_contents('./logs/' .$file, $data);
    }
    public function getPost(){
        return file_get_contents('php://input');
    }
    //Xml 文件转数组
    public function XmlToArr($xml)
    {
        if($xml == '') return '';
        libxml_disable_entity_loader(true);
        $arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $arr;
    }
    //数组转XML
    public function ArrToXml($arr)
    {
        if(!is_array($arr) || count($arr) == 0) return '';

        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }
    //post 字符串到接口
    public function postStr($url,$postfields){
        $ch = curl_init();
        $params[CURLOPT_URL] = $url;    //请求url地址
        $params[CURLOPT_HEADER] = false; //是否返回响应头信息
        $params[CURLOPT_RETURNTRANSFER] = true; //是否将结果返回
        $params[CURLOPT_FOLLOWLOCATION] = true; //是否重定向
        $params[CURLOPT_POST] = true;
        $params[CURLOPT_SSL_VERIFYPEER] = false;//禁用证书校验
        $params[CURLOPT_SSL_VERIFYHOST] = false;
        $params[CURLOPT_POSTFIELDS] = $postfields;
        curl_setopt_array($ch, $params); //传入curl参数
        $content = curl_exec($ch); //执行
        curl_close($ch); //关闭连接
        return $content;
    }
    public function push()
    {
        $data=input('post.');
        $where=[
            'goodid'=>$data['goodid'],
            'userid'=>$data['userid'],
            'type'=>1,
        ];
        $rel=Db::name('auction_record')->where($where)->find();
        if(!$rel)
        {
            show_api('','',0);
        }
        show_api();
    }
}