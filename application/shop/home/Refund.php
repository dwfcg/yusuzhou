<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/12
 * Time: 16:50
 */

namespace app\shop\home;
use think\Db;
use think\Config;
use Alipay\Alipaynotify;
use Wxpay\Wxpay;
use Yansongda\Pay\Pay;
use refund\alirefund\Refund as RefundClass;
class Refund    extends Common
{

    /**
     * 退款
     * @order_sn
     * $UID
     */
    public function applyRefund()
    {
        $data=input('post.');
        $where=[
            'order_sn'=>$data['order_sn'],
            'user_id'=>$data['uid']
        ];
        //查询是否申请过退款
        $res=Db::name('shop_refund')->where('order_sn',$data['order_sn'])->find();
        if($res)
        {
            show_api('','你已经申请过退款',0);
        }
        $result=Db::name('shop_order')->where($where)->find();
//        dump($result);
        if(!$result||$result['pay_status']==0)
        {
            show_api('','该订单不存在或尚未支付');
        }
        $update=[
            'order_sn'=>$data['order_sn'],
            'comment'=>$data['comment'],
            'images'=>$data['images'],
            'add_time'=>time(),
            'trade_no'=>$result['trade_no'],
            'good_id'=>$result['goods_id'],
        ];
        Db::name('shop_refund')->insert($update);
        show_api('','申请成功，等待商家回应',0);
    }

    /**
     *  获取用户退款订单快递信息
     * @order_sn
     * @EXPRESS_NO
     * @EXPRESS
     */
    public function getExpress()
    {
        $data=input('post.');
        $update=[
            'express_no'=>$data['express_no'],
            'express'=>$data['express']
        ];
//        dump($data);
        $result=Db::name('shop_refund')->where('order_sn',$data['order_sn'])->update($update);
        if($result)
        {
            show_api();
        }else
        {
            show_api('','未知原因报错',0);
        }
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
        if ($xmlArray['result_code'] == "SUCCESS") {
            $out_trade_no = $xmlArray['out_trade_no'];//订单号：业务逻辑区域
            $order_info = Db::name("shop_refund")->where("order_sn='{$out_trade_no}'")->find();
            //没有同步本地服务器数据
            if($order_info['status']==4)
            {
                $update['status']=4;
                $where['order_sn']=$out_trade_no;
                $res=Db::name("shop_refund")->where($where)->update($update);
                Db::name('shop_order')->where($where)->delete();
            }
            return $this->redirect('http://yusuzhou.youacloud.com/admin.php/shop/refund/index.html');

        } else {
//            echo "FAIL";
            return  $this->error('微信未处理成功');
            exit;
        }
    }
    public function alipayRrfund()
    {

    }
    public function demo1()
    {
        $alipay_config = Config::get('alipay_config');
        require_once EXTEND_PATH.'Alipay/alipaycore.php';

        require_once EXTEND_PATH.'Alipay/alipayrsa.php';
        //构造要请求的参数数组，无需改动
        $parameter = array(
            'partner'=>$alipay_config['partner'],//合作者身份ID
            'seller_user_id'=>$alipay_config['partner'],
            'total_fee'=>0.01,
            'notify_url'=>'http://yusuzhou.youacloud.com/index.php/shop/refund/alipayRrfund',//服务器异步通知页面路径
            'service'=>'refund_fastpay_by_platform_pwd',//接口名称
            'sign_type'=>'RSA',//支付类型
            '_input_charset'=>$alipay_config['input_charset'],//参数编码字符集
            'refund_date' => date('Y-m-d H:i:s') , //退款请求时间
            'batch_no' => date('Ymd') . '165161' ,//退款批次号 格式为：退款日期（8位）+流水号（3～24位）
            'batch_num' => 1 , //总笔数
            'detail_data' => '2018072021001004160577450006^0.01^退款', //单笔数据集 格式: 支付宝交易号^金额^退款理由
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
        $url = 'https://mapi.alipay.com/gateway.do?' . $data;
//        dump($url);
        header("location:" . $url);

    }
    public function refund($order_sn)
    {
        $order_info=Db::name('shop_order')->where('order_sn',$order_sn)->find();
        if($order_info['pay_type']==0)
        {
            $this->weixinRefund($order_info);
        }elseif ($order_info['pay_type']==2)
        {
            Db::name('user')->where(['id'=>$order_info['user_id']])->setInc('wallet',$order_info['price']);
        }
        else{
            $refundsever=new RefundClass();
            $refund_data=Db::name('shop_refund')->where('order_sn',$order_sn)->find();
            $detail_data=$refund_data['trade_no'].'^'.$order_info['price'].'^'.$refund_data['comment'];
//            dump($detail_data);die();
//            $detail_data = "2018072021001004160577450006^0.01^测试第一笔退款";
            $rel=$refundsever->oldRefund(1, $detail_data);
//            $this->demo1();
        }

    }
    //支付宝退款异步通知等以后处理微信退款同步直接处理
    public function refund_notify_url()
    {
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
            $order_info = Db::name("shop_refund")->where("order_sn='{$out_trade_no}'")->find();
            //没有同步本地服务器数据
                $update['status']=4;
                $where['order_sn']=$out_trade_no;
                $res=Db::name("shop_refund")->where($where)->update($update);
            echo "SUCCESS";exit;

        } else {
            echo "FAIL";
            exit;
        }
    }
    //查询微信订单
    public function refundquery()
    {
        $params = [
            'appid'   =>  'wx0578b9d04b418614', //APPID
            'mch_id'  => '1493283802', //商户号
//            'key'  => 'n0alu1cnrq8bdus6jcpnnhkig421suz6', //商户号
            'nonce_str'=> md5(time()), //随机串
            'sign'  => 'md5',          //签名方式
            'transaction_id'=> '4200000179201810132202376558',//微信支付订单号 与商户订单号二选一
        ];
        $signParams = $this->setSign($params);
        $xmlData = $this->ArrToXml($signParams);
//        dump($xmlData) ;die();
        //发送请求
        $re=$this->postStr('https://api.mch.weixin.qq.com/pay/orderquery', $xmlData);
        dump($re);

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

}