<?php
namespace app\auction\home;
use think\Config;
use think\Db;
use Alipay\Alipaynotify;
use Wxpay\Wxpay;
use Yansongda\Pay\Pay;
/**
 * Created by PhpStorm.
 * User: order_no,uid,gid,band,trade_no,pay_type,pay_status,pay_time,status,addtime
 * NickName: su
 * Date: 2018/9/10 10:42
 */
class Zhifu extends Common
{
    //    钱包支付
    public function walletpay()
    {
        $order_sn = input("post.order_sn");
        // $order_sn = '152877458092';
        if($order_sn == 0){
            show_api('','非法数据',0);
        }
        $order_info = Db::name('auction_band')->where("order_no={$order_sn}")->find();
        $total_fee = $order_info['band'];
        $user=Db::name('user')->where('id',$order_info['uid'])->find();
        $money=$user['wallet']-$total_fee;
//        dump($money);
        if($money>=0)
        {
            Db::name('user')->where('id',$order_info['uid'])->setDec('wallet',$total_fee);
            $update['pay_type']=3;
            $update['pay_status']=1;
            // $update['pay_sn']=$xmlArray['transaction_id'];
            $update['addtime']=time();
            $update['status']=1;
            $where['order_no']=$order_info['order_no'];

            $res=Db::name("auction_band")->where($where)->update($update);
            show_api();
        }else{
            return show_api('','',0);
        }
    }

    //支付宝支付
    function  alipay_before(){
        // $mid = '50';
        if(!$mid=input('request.mid')) show_api('','用户信息不存在',0);

        require_once EXTEND_PATH.'Alipay/alipaycore.php';

        require_once EXTEND_PATH.'Alipay/alipayrsa.php';

        $order_no = input("request.order_no");
        // $order_sn = '152877458092';
        if($order_no == 0){
            show_api('','非法数据',0);
        }
        $order_info = Db::name('auction_band')->where("order_no={$order_no}")->find();
        // var_dump($order_info);die;
        //建立请求
        $out_trade_no = $order_info['order_no'];
        // $total_fee = $order_info['total_price'] + $order_info['trans_price'];   //付款金额
        $total_fee = $order_info['band'];
        $body = '支付保证金';  //商品详情
        $alipay_config = Config::get('alipay_config');

        //构造要请求的参数数组，无需改动
        $parameter = array(
            'partner'=>$alipay_config['partner'],//合作者身份ID
            // 'seller_id'=>$alipay_config['seller_id'],
            'out_trade_no'=>$out_trade_no,//商户网站唯一订单号
            'subject'=>'订单支付',//商品名称
            'body'=>$body,//商品详情
            'total_fee'=>$total_fee,
            'notify_url'=>$alipay_config['notify_url'],//服务器异步通知页面路径
            'service'=>$alipay_config['service'],//接口名称
            'pay_type'=>$alipay_config['pay_type'],//支付类型
            'charset'=>$alipay_config['input_charset'],//参数编码字符集
        );
        // print_r($parameter);die;
        //将post接收到的数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串。
        $data = createLinkstring($parameter);
        //打印待签名字符串。工程目录下的log文件夹中的log.txt。
        logResult($data);

        //将待签名字符串使用私钥签名,且做urlencode. 注意：请求到支付宝只需要做一次urlencode.
        $rsa_sign = urlencode(rsaSign($data, $alipay_config['private_key']));
        // var_dump($rsa_sign);die;
        //把签名得到的sign和签名类型sign_type拼接在待签名字符串后面。
        $data = $data.'&sign='.'"'.$rsa_sign.'"'.'&sign_type='.'"'.$alipay_config['sign_type'].'"';
        // dump($data);die;

        //返回给客户端,建议在客户端使用私钥对应的公钥做一次验签，保证不是他人传输。
        // echo $data;
        $list['form'] = $data;
        // var_dump($list);die;
        show_api($list,'ok',1);
    }

     public function alipay_notify_url()
    {
            $alipay_config = Config::get('alipay_config');
            //计算得出通知验证结果
            $alipayNotify = new Alipaynotify($alipay_config);
            if($alipayNotify->getResponse($_POST['notify_id']))//判断成功之后使用getResponse方法判断是否是支付宝发来的异步通知。
            {
            // $fileName = 'pay.txt';     
          // $postData = var_export($alipayNotify->getSignVeryfy($_POST, $_POST['sign']), true);
    
         //    $postData = var_export($_POST, true);
          // $file     = fopen('' . $fileName, "a+");
          // fwrite($file,$postData);
          // fclose($file);
                //――请根据您的业务逻辑来编写程序（以下代码仅作参考）――
                //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
                //商户订单号
                $out_trade_no = $_POST['out_trade_no'];
                //支付宝交易号
                $trade_no = $_POST['trade_no'];
                //交易状态
                $trade_status = $_POST['trade_status'];
                 if($_POST['trade_status'] == 'TRADE_SUCCESS') {
                    $order_info = Db::name("auction_band")->where("order_no={$out_trade_no}")->find();
                    if($order_info['status'] == 0){
                        //更新支付状态和支付时间
                        $data['pay_type']=1;
                        $data['pay_status']=1;
                        $data['trade_no']=$trade_no;
                        $data['pay_time']=time();
                        $data['status']=1;
                       $where['order_no']=$order_info['order_no'];
                        $res=Db::name("auction_band")->where($where)->update($data);
                        // $this->fenxiao_account($out_trade_no);
                    }
                }
                //――请根据您的业务逻辑来编写程序（以上代码仅作参考）――
                echo "success";   //请不要修改或删除

          }else{
            //验证是否来自支付宝的通知失败
              echo "response fail";
          }
    }

    //微信支付-统一下单
    public function wxpay_before(){
        // $mid=127;     
        // if(!$mid=input('request.mid')) show_api('','用户信息不存在',0);
         // $order_sn = input("request.order_sn");
        $order_no = trim(input("request.order_no",0));
        $order_no='2018083118084542652';
        if($order_no == 0){
            show_api('','非法数据',0);
        }
        $order_info = Db::name("auction_band")->where("order_no={$order_no}")->find();
        $goods_info = Db::name('auction_goods')->where('id',$order_info['gid'])->value('title');
        //建立请求
        $out_trade_no = $order_info['order_no'];
        // $total_fee = $order_info['total_price'] + $order_info['trans_price'];   //付款金额
        $total_fee = $order_info['band'];
        $body = $goods_info;  //商品详情
        $wxpay_config = Config::get('wxpay_config');
        $config = [
              'wechat' =>[
                  'appid'=>$wxpay_config['appid'], //appid
                  'mch_id'=>$wxpay_config['mch_id'], //微信商户号
                  'notify_url'=>$wxpay_config['notify_url'],
                  // 'key'=>$wxpay_config['key'],//微信签名密钥
                  'key'=>'n0alu1cnrq8bdus6jcpnnhkig421suz6',
                  'cert_client'=>'./apiclient_cert.pem',//客户端证书路径，退款时需要用到
                  'cert_key'=>'./apiclient_key.pem',//客户端秘钥路径,退款时需要用到
              ],
        ];
        $config_biz = [
               'out_trade_no'=>$out_trade_no,//订单号
               'total_fee'=>intval($total_fee*100),//订单金额
               'body'=>$body, //订单描述
               'spbill_create_ip'=>$this->get_client_ip(),//支付人的ip
        ];
        $pay = new Pay($config);
        $res = $pay->driver('wechat')->gateway('app')->pay($config_biz);
        show_api($res,'支付参数',1);
    }
    public function weixin_notify_url(){

        //接受xml数据流开始
        $data = file_get_contents("php://input");//字符串数据流
        libxml_disable_entity_loader(true);
        $xmlArray = json_decode(json_encode(simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);//xml数据转换成array 转换形式良好的XML字符串为 SimpleXMLElement对象。
        //接受xml数据流结束
          $fileName = 'a.txt'; 
            $postData = var_export($xmlArray, true);
          $file = fopen('' . $fileName, "a+");
          fwrite($file,$postData);
          fclose($file);
        //php写一个日志文件
        //$xml可以理解为微信服务器返回给我们标准的php数组
        //支付成功
        if ($xmlArray['result_code'] == "SUCCESS") {
            $out_trade_no = $xmlArray['out_trade_no'];//订单号：业务逻辑区域
            $order_info = Db::name("auction_band")->where("order_no='{$out_trade_no}'")->find();
            //没有同步本地服务器数据
            if ($order_info['status'] == 0) {
                        $update['pay_type']=2;
                        $update['pay_status']=1;
                        // $update['pay_sn']=$xmlArray['transaction_id'];
                        $update['trade_no']=$xmlArray['transaction_id'];
                        $update['addtime']=time();
                        $update['status']=1;
            $where['order_no']=$out_trade_no;
          // $fileName = 'c.txt'; 
         //    $postData = var_export($update, true);
          // $file     = fopen('' . $fileName, "a+");
          // fwrite($file,$postData);
          // fclose($file);
                        $res=Db::name("auction_band")->where($where)->update($update);
                // $this->fenxiao_account($out_trade_no);
            }
            echo "SUCCESS";exit;

        } else {
            echo "FAIL";
            exit;
        }
    }
    /**
     *
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return 产生的随机字符串
     */
    public function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }
    //检测库存
    public function setGoodsNum($good_id)
    {
//        $good_id="49,50,51";
        $goods_id = explode(',',$good_id);
        $goods = Db::name('shop_goods')
            ->where('id','in',$goods_id)
            ->field('id,sku')
            ->select();
        $data=[];
        foreach ($goods as $k =>$v)
        {
            if($v['sku']==0)
            {
                $data[]=$v['id'];

            }
        }
        if($data)
        {
            show_api($data,'存在库存不足',0);
        }
    }
    //减少库存
    public function descNum($good_id)
    {
        $goods_id = explode(',',$good_id);
        Db::name('shop_goods')
            ->where('id','in',$goods_id)
            ->field('id,sku')
            ->setDec('sku');
    }
    public function get_arr_column($arr, $key_name)
    {
        $arr2 = array();
        foreach($arr as $key => $val){
            $arr2[] = $val[$key_name];
        }
        return $arr2;
    }
}