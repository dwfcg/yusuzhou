<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/12
 * Time: 13:16
 */

namespace app\shop\home;
use com\unionpay\acp\sdk\SDKConfig;
use com\unionpay\acp\sdk\AcpService;

use app\index\controller\Home;
use think\Config;
use think\Db;
use Alipay\Alipaynotify;
use Wxpay\Wxpay;
use Yansongda\Pay\Pay;

class Recharge  extends Common
{

    public function demo()
    {
        $str='2,7,36,38';
        $str=explode(',',$str);
        dump($str);
//        $category=array_filter(explode(',',$str));
//        dump($category);
        foreach ($str as $k =>$v)
        {
           $cate[]=[
               'shopgoods_id'=>1,
               'category_id'=>$v,
               ];
        }
        dump($cate);
        Db::name('categorygoods')->insertAll($cate);
    }
    /**
     * 直接请求这个方法再请求充值方法
     * 也可一步到位 由于需测试 暂时这样做
     * 记录充值
     * @uid用户ID
     * @price充值金额
     */
    public function addRecharge()
    {
        $data=input('post.');
        $insert=[
            'user_id'=>$data['uid'],
            'price'=>$data['price'],
        ];
        $rechargeID=Db::name('user_recharge')->insertGetId($insert);
        $update['order_sn'] = time().$rechargeID;
        Db::name('user_recharge')->where('id',$rechargeID)->update($update);
        show_api( $update['order_sn']);
    }
    public function recharge($uid,$price)
    {
        $data=Db::name('user_recharge')->where('id',$uid)->setInc('wallet',$price);
    }

//支付宝充值
    function  alipay_before(){

        require_once EXTEND_PATH.'Alipay/alipaycore.php';

        require_once EXTEND_PATH.'Alipay/alipayrsa.php';

        $order_sn = input("post.order_sn");
//        dump($order_sn);
//         $order_sn = '152877458092';

        if($order_sn == 0){
            show_api('','非法数据',0);
        }
        $order_info = Db::name('user_recharge')->where("order_sn={$order_sn}")->find();
        // var_dump($order_info);die;
        //建立请求
        $out_trade_no = $order_info['order_sn'];
        // $total_fee = $order_info['total_price'] + $order_info['trans_price'];   //付款金额
        $total_fee = $order_info['price'];
        $body = '订单支付';  //商品详情
        $alipay_config = Config::get('alipay_config');

        //构造要请求的参数数组，无需改动
        $parameter = array(
            'partner'=>$alipay_config['partner'],//合作者身份ID
            // 'seller_id'=>$alipay_config['seller_id'],
            'out_trade_no'=>$out_trade_no,//商户网站唯一订单号
            'subject'=>'订单支付',//商品名称
            'body'=>$body,//商品详情
            'total_fee'=>$total_fee,
            'notify_url'=>'http://yusuzhou.youacloud.com/index.php/shop/recharge/alipay_notify_url',//服务器异步通知页面路径
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
         var_dump($list);die;
//        show_api($list,'ok',1);
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

                $order_info = Db::name("user_recharge")->where("order_sn={$out_trade_no}")->find();
                if($order_info['pay_status'] == 0){
                    //更新支付状态和支付时间
                    $data['pay_type']=1;
                    $data['pay_status']=1;
                    $data['trade_no']=$trade_no;
                    $data['pay_time']=time();
                    $where['order_sn']=$order_info['order_sn'];

                    $res=Db::name("user_recharge")->where($where)->update($data);
                    $this->recharge($order_info['user_id'],$order_info['price']);


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

    //微信支付充值
    public function wxpay_before(){
        $order_sn = trim(input("post.order_sn",0));
        if($order_sn == 0){
            show_api('','非法数据',0);
        }
        $order_info = Db::name("user_recharge")->where("order_sn={$order_sn}")->find();
        //建立请求
        $out_trade_no = $order_info['order_sn'];
        // $total_fee = $order_info['total_price'] + $order_info['trans_price'];   //付款金额
        $total_fee = $order_info['price'];
        $body = '充值订单';  //商品详情
        $wxpay_config = Config::get('wxpay_config');
        $config = [
            'wechat' =>[
                'appid'=>$wxpay_config['appid'], //appid
                'mch_id'=>$wxpay_config['mch_id'], //微信商户号
                'notify_url'=>'http://yusuzhou.youacloud.com/index.php/shop/recharge/weixin_notify_url',
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

    //调起支付接口
    // public function wxpay_getOrder($data){
    //     $wxpay = new Wxpay($data);
    //     $data['sign'] = $wxpay->SetSign();//设置sign,第二次设置签名
    //     // dump($data['sign']);exit;
    //     show_api($data,'ok',1);
    // }
    public function weixin_notify_url(){

        //接受xml数据流开始
        $data = file_get_contents("php://input");//字符串数据流
        libxml_disable_entity_loader(true);
        $xmlArray = json_decode(json_encode(simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);//xml数据转换成array 转换形式良好的XML字符串为 SimpleXMLElement对象。
        //接受xml数据流结束
        $fileName = 'a.txt';
        $postData = var_export($xmlArray, true);
        $file     = fopen('' . $fileName, "a+");
        fwrite($file,$postData);
        fclose($file);
        //php写一个日志文件
        //$xml可以理解为微信服务器返回给我们标准的php数组
        //支付成功
        if ($xmlArray['result_code'] == "SUCCESS") {
            $out_trade_no = $xmlArray['out_trade_no'];//订单号：业务逻辑区域
            $order_info = Db::name("user_recharge")->where("order_sn='{$out_trade_no}'")->find();
            //没有同步本地服务器数据
            if ($order_info['pay_status'] == 0) {
                $update['pay_type']=0;
                $update['pay_status']=1;
                // $update['pay_sn']=$xmlArray['transaction_id'];
                $update['trade_no']=$xmlArray['transaction_id'];
                $update['pay_time']=time();
                $where['order_sn']=$out_trade_no;
                // $fileName = 'c.txt';
                //    $postData = var_export($update, true);
                // $file     = fopen('' . $fileName, "a+");
                // fwrite($file,$postData);
                // fclose($file);
                $res=Db::name("user_recharge")->where($where)->update($update);
                $this->recharge($order_info['user_id'],$order_info['price']);
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
    /*
    获取当前服务器的IP
    */
    public function get_client_ip()
    {
        if ($_SERVER['REMOTE_ADDR']) {
            $cip = $_SERVER['REMOTE_ADDR'];
        } elseif (getenv("REMOTE_ADDR")) {
            $cip = getenv("REMOTE_ADDR");
        } elseif (getenv("HTTP_CLIENT_IP")) {
            $cip = getenv("HTTP_CLIENT_IP");
        } else {
            $cip = "unknown";
        }
        return $cip;
    }
    //=银联支付
    public function unionpay()
    {
//        require_once EXTEND_PATH.'com\unionpay\acp\sdk\AcpService';
        $data=input('post.');
        $order_sn=$data['order_sn'];
        $orderInfo = Db::name("user_recharge")->where("order_sn={$order_sn}")->find();
        dump($orderInfo);
        $serves=new SDKConfig();
        $AcpService=new AcpService();
//       echo $serves::getSDKConfig()->signMethod;die();
        $params = array(

            //以下信息非特殊情况不需要改动
            'version' => $serves::getSDKConfig()->version,                 //版本号
            'encoding' => 'utf-8',				  //编码方式
            'txnType' => '01',				      //交易类型
            'txnSubType' => '01',				  //交易子类
            'bizType' => '000201',				  //业务类型
            'frontUrl' =>  $serves::getSDKConfig()->frontUrl,  //前台通知地址
            'backUrl' =>$serves::getSDKConfig()->backUrl,	  //后台通知地址
            'signMethod' => $serves::getSDKConfig()->signMethod,	              //签名方法
            'channelType' => '08',	              //渠道类型，07-PC，08-手机
            'accessType' => '0',		          //接入类型
            'currencyCode' => '156',	          //交易币种，境内商户固定156

            //TODO 以下信息需要填写
            'merId' => '880000000000761',		//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
            'orderId' => $orderInfo['order_sn'],	//商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则
            'txnTime' => date('YmdHis',$orderInfo['pay_time']),	//订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数
            'txnAmt' => $orderInfo['price']*10,	//交易金额，单位分，此处默认取demo演示页面传递的参数

            // 请求方保留域，
            // 透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据。
            // 出现部分特殊字符时可能影响解析，请按下面建议的方式填写：
            // 1. 如果能确定内容不会出现&={}[]"'等符号时，可以直接填写数据，建议的方法如下。
            //    'reqReserved' =>'透传信息1|透传信息2|透传信息3',
            // 2. 内容可能出现&={}[]"'符号时：
            // 1) 如果需要对账文件里能显示，可将字符替换成全角＆＝｛｝【】“‘字符（自己写代码，此处不演示）；
            // 2) 如果对账文件没有显示要求，可做一下base64（如下）。
            //    注意控制数据长度，实际传输的数据长度不能超过1024位。
            //    查询、通知等接口解析时使用base64_decode解base64后再对数据做后续解析。
            //    'reqReserved' => base64_encode('任意格式的信息都可以'),

            //TODO 其他特殊用法请查看 pages/api_05_app/special_use_preauth.php

        );
        $AcpService::sign ( $params ); // 签名
        $url =$serves::getSDKConfig()->appTransUrl;

        $result_arr =$AcpService::post ( $params, $url);
        if(count($result_arr)<=0) { //没收到200应答的情况
            $this->printResult ( $url, $params, "" );
            return;
        }

        $this->printResult ($url, $params, $result_arr ); //页面打印请求应答数据

        if (!$AcpService::validate ($result_arr) ){
            echo "应答报文验签失败<br>\n";
            return;
        }

//        echo "应答报文验签成功<br>\n";
        if ($result_arr["respCode"] == "00"){
            //成功
            //TODO
//            echo "成功接收tn：" . $result_arr["tn"] . "<br>\n";
//            echo "后续请将此tn传给手机开发，由他们用此tn调起控件后完成支付。<br>\n";
//            echo "手机端demo默认从仿真获取tn，仿真只返回一个tn，如不想修改手机和后台间的通讯方式，【此页面请修改代码为只输出tn】。<br>\n";
            show_api($result_arr["tn"]);
        } else {
            //其他应答码做以失败处理
            //TODO
            echo "失败：" . $result_arr["respMsg"] . "。<br>\n";
            show_api('','',0);
        }
    }
    public function printResult($url, $req, $resp) {
        $AcpService=new AcpService();
        echo "=============<br>\n";
        echo "地址：" . $url . "<br>\n";
        echo "请求：" . str_replace ( "\n", "\n<br>", htmlentities ( $AcpService::createLinkString ( $req, false, true ) ) ) . "<br>\n";
        echo "应答：" . str_replace ( "\n", "\n<br>", htmlentities ( $AcpService::createLinkString ( $resp , false, false )) ) . "<br>\n";
        echo "=============<br>\n";
    }
}