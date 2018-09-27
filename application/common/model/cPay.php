<?php



/*

 * author : 安德兔

 * link : http://www.andetu.com/code/1861

 */



namespace app\common\model;



use think\Validate;

use think\Log;



class cPay extends \think\Model {



    private function _weixin_config() {

        define('WXPAY_APPID', "wx78ca1b05b85b8546"); //微信公众号APPID

        define('WXPAY_MCHID', "1378227602"); //微信商户号MCHID

        define('WXPAY_KEY', "Mhjfdsklgmkls2549816515555572653"); //微信商户自定义32位KEY

        define('WXPAY_APPSECRET', "41368c763986f9a1822181158bded91c"); //微信公众号appsecret

        vendor('wxpay.WxPay_Api');

        vendor('wxpay.WxPay_NativePay');

    }



    public static $alipay_config = [

        'partner' => '2088221502617235', //支付宝partner，2088开头数字

        'seller_id' => '2088221502617235', //支付宝partner，2088开头数字

        'key' => 'a2odv9jbgwm8sn08c7aocy61bdq6xwos', //支付宝密钥

        'sign_type' => 'MD5',

        'input_charset' => 'utf-8',

        'cacert' => '',

        'transport' => 'http',

        'payment_type' => '1',

        'service' => 'alipay.wap.create.direct.pay.by.user',

        'anti_phishing_key' => '',

        'exter_invoke_ip' => '',

    ];



    public function weixin($data = []) {

        $validate = new Validate([

            ['body', 'require', '请输入订单描述'],

            ['attach', 'require', '请输入订单标题'],

            ['out_trade_no', 'require|alphaNum', '订单编号输入错误|订单编号输入错误'],

            ['total_fee', 'require|number|gt:0', '金额输入错误|金额输入错误|金额输入错误'],

            ['notify_url', 'require', '异步通知地址不为空'],

            ['trade_type', 'require|in:JSAPI,NATIVE,APP', '交易类型错误'],

        ]);

        if (!$validate->check($data)) {

            return ['code' => 0, 'msg' => $validate->getError()];

        }



        $this->_weixin_config();

        $notify = new \NativePay();

        $input = new \WxPayUnifiedOrder();

        $wxapi = new \WxPayApi();

        $input->SetBody($data['body']);

        $input->SetAttach($data['attach']);

        $input->SetOut_trade_no($data['out_trade_no']);

        $input->SetTotal_fee($data['total_fee']);

        $input->SetTime_start($data['time_start']);

        $input->SetTime_expire($data['time_expire']);

        $input->SetGoods_tag($data['goods_tag']);

        $input->SetNotify_url($data['notify_url']);

        $input->SetTrade_type($data['trade_type']);

        $input->SetProduct_id($data['product_id']);

        $result = $notify->GetPayUrl($input);





        $show['appid'] = WXPAY_APPID;

        $show['partnerid'] = WXPAY_MCHID;

        $show['prepayid'] = $result['prepay_id'];

        $show['package'] = 'Sign=WXPay';

        $show['noncestr'] = $wxapi->getNonceStr(32);

        $show['timestamp'] = (string) time();

        $show['sign'] = $this->getSign($show);

        unset($show['package']);

        $show['attach'] = 'Sign=WXPay';

        $last = json_encode($show);

        return $last;

    }



    public function getSign($Obj) {

        foreach ($Obj as $k => $v) {

            $Parameters[$k] = $v;

        }

        //签名步骤一：按字典序排序参数

        ksort($Parameters);

        $String = $this->formatBizQueryParaMap($Parameters, false);

        //echo '【string1】'.$String.'</br>';

        //签名步骤二：在string后加入KEY

        $String = $String . "&key=" . WXPAY_KEY;

        //echo "【string2】".$String."</br>";

        //签名步骤三：MD5加密

        $String = md5($String);

        //echo "【string3】 ".$String."</br>";

        //签名步骤四：所有字符转为大写

        $result_ = strtoupper($String);

        //echo "【result】 ".$result_."</br>";

        return $result_;

    }



    public function formatBizQueryParaMap($paraMap, $urlencode) {

        $buff = "";

        ksort($paraMap);

        foreach ($paraMap as $k => $v) {

            if ($urlencode) {

                $v = urlencode($v);

            }

            //$buff .= strtolower($k) . "=" . $v . "&";

            $buff .= $k . "=" . $v . "&";

        }

        $reqPar;

        if (strlen($buff) > 0) {

            $reqPar = substr($buff, 0, strlen($buff) - 1);

        }

        return $reqPar;

    }



    public function notify_weixin($data = '') {

        if (!$data) {

            return false;

        }

        $this->_weixin_config();

        $doc = new \DOMDocument();

        $doc->loadXML($data);

        $out_trade_no = $doc->getElementsByTagName("out_trade_no")->item(0)->nodeValue;

        $transaction_id = $doc->getElementsByTagName("transaction_id")->item(0)->nodeValue;

        $openid = $doc->getElementsByTagName("openid")->item(0)->nodeValue;

        $input = new \WxPayOrderQuery();

        $input->SetTransaction_id($transaction_id);

        $result = \WxPayApi::orderQuery($input);

        if (array_key_exists("return_code", $result) && array_key_exists("result_code", $result) && $result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS") {

            // 处理支付成功后的逻辑业务

            Log::init([

                'type' => 'File',

                'path' => LOG_PATH . '../paylog/'

            ]);

            Log::write($result, 'log');

            return array('status'=>'SUCCESS','out_trade_no'=>$out_trade_no,'transaction_id'=>$transaction_id);

        }

        return array('status'=>'');

    }



    public function alipay($data = []) {

        $validate = new Validate([

            ['out_trade_no', 'require|alphaNum', '订单编号输入错误|订单编号输入错误'],

            ['total_fee', 'require|number|gt:0', '金额输入错误|金额输入错误|金额输入错误'],

            ['subject', 'require', '请输入标题'],

            ['body', 'require', '请输入描述'],

            ['notify_url', 'require', '异步通知地址不为空'],

        ]);

        if (!$validate->check($data)) {

            return ['code' => 0, 'msg' => $validate->getError()];

        }

        $config = self::$alipay_config;

        vendor('alipay.alipay');

        $parameter = [

            "service" => $config['service'],

            "partner" => $config['partner'],

            "seller_id" => $config['seller_id'],

            "payment_type" => $config['payment_type'],

            "notify_url" => $data['notify_url'],

            "return_url" => $data['return_url'],

            "anti_phishing_key" => $config['anti_phishing_key'],

            "exter_invoke_ip" => $config['exter_invoke_ip'],

            "out_trade_no" => $data['out_trade_no'],

            "subject" => $data['subject'],

            "total_fee" => $data['total_fee'],

            "body" => $data['body'],

            'app'=>'Y',

            "_input_charset" => $config['input_charset']

        ];

        $alipaySubmit = new \AlipaySubmit($config);

        return ['code' => 1, 'msg' => $alipaySubmit->buildRequestForm($parameter, "get", "确认")];

    }



    public function notify_alipay() {

        $config = self::$alipay_config;

        vendor('alipay.alipay');

        $alipayNotify = new \AlipayNotify($config);

        if ($result = $alipayNotify->verifyNotify()) {

            if (input('trade_status') == 'TRADE_FINISHED' || input('trade_status') == 'TRADE_SUCCESS') {

                // 处理支付成功后的逻辑业务

                Log::init([

                    'type' => 'File',

                    'path' => LOG_PATH . '../paylog/'

                ]);

                Log::write($result, 'log');

                return 'success';

            }

            return 'fail';

        }

        return 'fail';

    }



}



?>