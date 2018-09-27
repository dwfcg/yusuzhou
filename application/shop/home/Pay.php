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



namespace app\shop\home;



use app\index\controller\Home;

use app\common\model\cPay;

use think\Db;



/**

 * 前台首页控制器

 * @package app\shop\admin

 */

class Pay extends Home {



    protected function _initialize()

    {

        parent::_initialize();

    }



    //支付页面

    public function pay() {

        $order_id = input('id', '', 'intval');

        $order = DB('ShopOrder')->where('id', $order_id)->find();

        $this->assign('order', $order);

        return $this->fetch();

    }



    //微信支付

    public function weixin() {

        $order_id = input('id', '', 'intval');

        if( !$order_id ){

            $this->error('订单ID不能为空'); 

         }

        $order = DB('ShopOrder')->where('id', $order_id)->find();

      // var_dump($order);die;

        $Pay = new cPay;

        $result = $Pay->weixin([

            'body' => '乐羊领书'.$order['order_sn'],

            'attach' => '书籍购买支付',

            'out_trade_no' => $order['id'],

            'total_fee' => $order['price'] * 100, //订单金额，单位为分，如果你的订单是100元那么此处应该为 100*100

            'time_start' => date("YmdHis"), //交易开始时间

            'time_expire' => date("YmdHis", time() + 604800), //一周过期

            'goods_tag' => '在线支付',

            'notify_url' => request()->domain() . url('shop/pay/weixin_notify'),

            'trade_type' => 'APP',

            'product_id' => rand(1, 999999),

        ]);

        $this->view->orderid = $order['order_sn'];

        $this->assign('last',$result);

        return $this->fetch();

    }

 

	

    //微信支付回推

    public function weixin_notify() {

        $notify_data = file_get_contents("php://input");

        if (!$notify_data) {

            $notify_data = $GLOBALS['HTTP_RAW_POST_DATA'] ? : '';

        }

        if (!$notify_data) {

            exit('');

        }

        $Pay = new cPay;

        $result = $Pay->notify_weixin($notify_data);

        if( $result['status'] == 'SUCCESS' ){

            $order_id = $result['out_trade_no'];

            $trade_no = $result['transaction_id'];

            DB('ShopOrder')->where('id',$order_id)->update(array(

                'pay_type'=>'2',

                'pay_time'=>time(),

                'trade_no'=>$trade_no,

                'status'=>1

            ));

        }

        exit($result['status']);

    }



    //支付宝支付

    public function alipay() {

            $order_id = input('id', '', 'intval');

            if( !$order_id ){

               $this->error('订单ID不能为空'); 

            }

            $order = DB('ShopOrder')->where('id', $order_id)->find();

            $Pay = new cPay;

            $result = $Pay->alipay([

                'notify_url' => request()->domain() . url('shop/pay/alipay_notify'),

                'return_url' => request()->domain() . url('shop/pay/alipay_return'),

                'out_trade_no' => $order['id'],

                'subject' => '书籍购买支付',

                'total_fee' => $order['price'], //订单金额，单位为元

                'body' => '书籍购买支付',

            ]);

            if (!$result['code']) {

                return $this->error($result['msg']);

            }

            return $result['msg'];

            

        $this->view->orderid = $order['id'];

        return $this->fetch();

    }



    //支付宝回推

    public function alipay_notify() {

        $Pay = new cPay;

        $result = $Pay->notify_alipay();

        if ($result == 'success') {

            $order_id = input('out_trade_no');

            $trade_no = input('trade_no');

            DB('ShopOrder')->where('id',$order_id)->update(array(

                'pay_type'=>'1',

                'pay_time'=>time(),

                'trade_no'=>$trade_no,

                'status'=>1

            ));

        }

        exit($result);

    }

    public function alipay_return(){

        $this->success('支付成功',url('shop/order/orders'));

    }



}

