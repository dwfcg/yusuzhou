<?php
namespace app\collect\home;
use think\Config;
use think\Db;
use Alipay\Alipaynotify;
use Wxpay\Wxpay;
use Yansongda\Pay\Pay;
use com\unionpay\acp\sdk\SDKConfig;
use com\unionpay\acp\sdk\AcpService;
/**
 * Created by PhpStorm.
 * User: 413010640@qq.com
 * NickName: agui
 * Date: 2018/6/20
 */
class Zhifu extends Common
{
    //回扣
    public function back($good_id,$uid)
    {
        $goodsData=Db::name('shop_goods')->find($good_id);
        $userData= Db::name('user')->find($uid);
        if(!$userData['leader'])
        {
            return false;
        }else{
            $leader=Db::name('user')->find($userData['leader']);
            $update=[
                'income'=>$leader['income']+$goodsData['back'],
                'withdraw'=>$leader['withdraw']+$goodsData['back']
            ];
            Db::name('user')->where('id',$userData['leader'])->update($update);
        }


    }
    public function integral($uid)
    {
        $user=Db::name('user')->where('id',$uid)->find();
        $ship=Db::name('user_ship')->order('level desc')->select();
        $integta=Db::name('user_setintegral')->find(1);
        foreach ($ship as $k =>$v )
        {
            if($user['total_amount']>=$v['condition'])
            {
                $data[]=$v;
            }
        }
        $update=[
            'level'=>$data[0]['level'],
            'integral'=>$user['integral']+$integta['buygoods']
        ];
        Db::name('user')->where('id',$uid)->update($update);

    }
    //获得订单信息
    public function orderInfo($order_sn)
    {
        $orderInfo=Db::name('collect_order')->where('order_sn',$order_sn);
        $this->setGoodsNum($orderInfo['goods_id']);
        return $orderInfo;

    }
    //=银联支付
    public function unionpay()
    {
//        require_once EXTEND_PATH.'com\unionpay\acp\sdk\AcpService';
        $data=input('post.');
        $orderInfo=$this->orderInfo($data['order_sn']);
        $serves=new SDKConfig();
        $AcpService=new AcpService();
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
            'txnTime' => date('YmdHis',$orderInfo['add_time']),	//订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数
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
            show_api($result_arr);
        } else {
            //其他应答码做以失败处理
            //TODO
//            echo "失败：" . $result_arr["respMsg"] . "。<br>\n";
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
    //    钱包支付
    public function walletpay()
    {
        $order_sn = input("post.order_sn");
        // $order_sn = '152877458092';
        if($order_sn == 0){
            show_api('','非法数据',0);
        }
        $order_info = Db::name('collect_order')->where("order_sn={$order_sn}")->find();
        $this->setGoodsNum($order_info['goods_id']);
        $out_trade_no = $order_info['order_sn'];
        $total_fee = $order_info['price'];
        $user=Db::name('user')->where('id',$order_info['user_id'])->find();
        $money=$user['wallet']-$total_fee;
        if(is_int($money))
        {
            //增加累计额度 咱判断会员等级和积分增加
            Db::name('user')->where('id',$order_info['user_id'])->setInc('total_amount',$total_fee);

            $this->integral($user['id']);
            //对订单表的处理
            $data['pay_type']=3;
            $data['pay_status']=1;
            $data['pay_time']=time();
            $data['status']=1;
            $where['order_sn']=$order_info['order_sn'];

            $res=Db::name("collect_order")->where($where)->update($data);
            $this->descNum($order_info['goods_id']);
            $this->back($order_info['goods_id'],$order_info['user_id']);
            show_api();
        }else{
            return show_api('','',0);
        }
    }
    //检测库存
    public function setGoodsNum($good_id)
    {
//        $good_id="49,50,51";
        $goods_id = explode(',',$good_id);
        $goods = Db::name('collect_good')
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
        Db::name('collect_good')
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
    //支付宝支付
    function  alipay_before(){
        // $mid = '50';
        if(!$mid=input('request.mid')) show_api('','用户信息不存在',0);

        require_once EXTEND_PATH.'Alipay/alipaycore.php';

        require_once EXTEND_PATH.'Alipay/alipayrsa.php';

        $order_sn = input("request.order_sn");
        // $order_sn = '152877458092';
        if($order_sn == 0){
            show_api('','非法数据',0);
        }
        $order_info = Db::name('collect_order')->where("order_sn={$order_sn}")->find();
        $this->setGoodsNum($order_info['goods_id']);
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

                    $order_info = Db::name("collect_order")->where("order_sn={$out_trade_no}")->find();
                    if($order_info['status'] == 0){
                        //更新支付状态和支付时间
                        $data['pay_type']=1;
                        $data['pay_status']=1;
                        $data['trade_no']=$trade_no;
                        $data['pay_time']=time();
                        $data['status']=1;
            $where['order_sn']=$order_info['order_sn'];

                        $res=Db::name("collect_order")->where($where)->update($data);
                        $this->descNum($order_info['goods_id']);
//                $user=Db::name("user")->where('id',$order_info['user_id'])->find();
//                //积分和累计额度增加
//                $update=[
//                    'total_amount'=>$user['total_amount']
//                ];
//                Db::name("user")->where('id',$order_info['user_id'])->update($update);
                        //增加累计额度 咱判断会员等级和积分增加
                        Db::name('user')
                            ->where('id',$order_info['user_id'])
                            ->setInc('total_amount',$order_info['price']);
                        $this->integral($order_info['user_id']);
                        $this->back($order_info['goods_id'],$order_info['user_id']);
     
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
        if(!$mid=input('request.mid')) show_api('','用户信息不存在',0);
        // $order_sn = input("request.order_sn");
        $order_sn = trim(input("request.order_sn",0));
        if($order_sn == 0){
            show_api('','非法数据',0);
        }
        $order_info = Db::name("collect_order")->where("order_sn={$order_sn}")->find();
        $this->setGoodsNum($order_info['goods_id']);
        $goods_info = Db::name('collect_good')->where('id',$order_info['goods_id'])->value('title');
        //建立请求
        $out_trade_no = $order_info['order_sn'];
        // $total_fee = $order_info['total_price'] + $order_info['trans_price'];   //付款金额
        $total_fee = $order_info['price'];
        $body = '订单支付';  //商品详情
        $wxpay_config = Config::get('wxpay_config');
        $config = [
              'wechat' =>[
                  'appid'=>$wxpay_config['appid'], //appid
                  'mch_id'=>$wxpay_config['mch_id'],//微信商户号
                  'notify_url'=>$wxpay_config['notify_url'], 
                  // 'key'=>$wxpay_config['key'],//微信签名密钥
                  'key'=>'n0alu1cnrq8bdus6jcpnnhkig421suz6',
                  'cert_client'=>'./apiclient_cert.pem',//客户端证书路径，退款时需要用到
                  'cert_key'=>'./apiclient_key.pem',//客户端秘钥路径,退款时需要用到
              ],
        ];
        $config_biz = [
               'out_trade_no'=>$out_trade_no,
               'total_fee'=>intval($total_fee*100),
               'body'=>$body,
               'spbill_create_ip'=>$this->get_client_ip(),
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
        $xmlArray = json_decode(json_encode(simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        //xml数据转换成array 转换形式良好的XML字符串为 SimpleXMLElement对象。
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
            $order_info = Db::name("collect_order")->where("order_sn='{$out_trade_no}'")->find();
            //没有同步本地服务器数据
            if ($order_info['status'] == 0) {
                        $update['pay_type']=0;
                        $update['pay_status']=1;
                        // $update['pay_sn']=$xmlArray['transaction_id'];
                        $update['trade_no']=$xmlArray['transaction_id'];
                        $update['pay_time']=time();
                        $update['status']=1;
            $where['order_sn']=$out_trade_no;

          // $fileName = 'c.txt'; 
         //    $postData = var_export($update, true);
          // $file     = fopen('' . $fileName, "a+");
          // fwrite($file,$postData);
          // fclose($file);
                        $res=Db::name("collect_order")->where($where)->update($update);
                $this->descNum($order_info['goods_id']);
//                $user=Db::name("user")->where('id',$order_info['user_id'])->find();
//                //积分和累计额度增加
//                $update=[
//                    'total_amount'=>$user['total_amount']
//                ];
//                Db::name("user")->where('id',$order_info['user_id'])->update($update);
                //增加累计额度 咱判断会员等级和积分增加
                Db::name('user')
                    ->where('id',$order_info['user_id'])
                    ->setInc('total_amount',$order_info['price']);
                $this->integral($order_info['user_id']);
                $this->back($order_info['goods_id'],$order_info['user_id']);
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

    

    //订单列表
    public function order_list(){
       
      if(!$mid=input('request.mid')) show_api('','用户信息不存在',0);
        // $mid=52;
          // $status = input("request.status",0);
          // // $status =1;

          // if($status==0){
          //   $res = Db::name("order")->where("mid={$mid}")->order('create_time desc')->paginate(100);
          //  }else{
          //   $res = Db::name("order")->where("mid={$mid} and status>{$status}")->order('create_time desc')->paginate(100);
          //  }
      $res = Db::name("order")->where("mid={$mid}")->order('create_time desc')->paginate(100);
          $tempres = $res->toArray();
          $list = $tempres['data'];
          foreach ($list as $k=>$v){
              $list[$k]['order_goods'] = Db::name('order_goods')->alias('a')
                ->join("goods b",'a.goods_id=b.gid',"LEFT")
                ->where("a.order_id={$v['id']}")
                ->field('a.*,b.pic')
                ->select();
        }

        show_api($list,'true',1);
    }

    //取消订单
    public  function order_cancel(){
        if(!$mid=input('request.mid')) show_api('','用户信息不存在',0);
        $order_sn = input("request.order_sn",0);
        if($order_sn==0) show_api('','数据非法',0);
        $res=  Db::name('order')->where("mid={$mid} and order_sn={$order_sn}")->find();
        if($res['status']==0) {
          Db::name('order')->where("mid={$mid} and order_sn={$order_sn}")->setField('status',-1);
           show_api('','取消成功',1);
        }else{
          show_api('','数据错误',0);
        }
       
    }


    //订单详情
    public function get_order_detail(){
      // $mid=52;
      if(!$mid=input('request.mid')) show_api('','用户信息不存在',0);
        $order_sn = input("request.order_sn",0);
        // $order_sn =2018050817181;
        if($order_sn ==0) show_api('','数据非法',0);
        // show_api($order_sn);
         // $list=  Db::name('order_goods')->where("order_id={$res['id']}")->select();

          // $res = Db::name("order")->where("mid={$mid}")->order('create_time desc')->find();
          $list=  Db::name('order')->alias('a')

             ->join("order_goods b",'a.id=b.order_id',"LEFT")

           ->where("a.mid={$mid} and a.order_sn={$order_sn}")
          
            ->select();
      // dump($res);exit;

            foreach ($list as $key => &$value) {

               $value['pic_id']=get_http().get_file_path($value['pic_id']);
            }
        
 
        show_api($list,'ok',1);
    }

    public function comment(){
        if(!$mid=input('request.mid')) show_api('','用户信息不存在',0);

        $content=input('request.content','');

        $order_sn=input('request.order_sn',0);

        if(empty($content) || $order_sn==0) shoe_api('','数据错误',0);

        $data['uid']=$mid;

        $data['content']=$content;

        $data['uid']=$mid;

        $data['time']=time();

        $data['order_sn']= $order_sn;

            $insert_id=Db::name('pinglun')->insertGetId($data);

            if($insert_id>0){

                Db::name('order')->where('order_sn',$order_sn)->update(['is_comment'=>1]);

                show_api('','评论成功',1);

            }else{
                 show_api('','评论失败',0);
            }


    }

}