<?php
//配置文件
return [
    //支付宝配置参数
    'alipay_config'=>array(
        //商户的私钥,此处填写原始私钥去头去尾，RSA公私钥生成：https://doc.open.alipay.com/doc2/

       'private_key'=>"MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAOCy81vXXNe6t6ZhkzXWCIIvD/xnH6Jsc87J0vwS5QHqOxASWAYCyTHjS7E4DZ3RSak1vXMZPrc/U2r1jVJKNnxR8QtC06YdP4hCbeFOCMPG6SYHvYVdOwGposMQ7UgRnZH/BlTtdtK/ze1laO8reBeMl/X5hjw4rNMVcmAVl2bFAgMBAAECgYEApJNNXWo67SMsGegDy32tk7RmsAbUC8IFfGMkbk5kf2eQxO+6mwR1Wl3RdcbJalr86bubu+60mcD/FysszCXhCwO+sw3zlflrKtM7CENCUxRCOFIs5pI3M+fqUM4pX9avzGRecShDqjIcRvMdBhYnZQA6aMWQBksik/+GYpWBQ2ECQQD7PVLO3aKaaG2SCmNuNLI9siI2l8kTpVyQIkSUYjimzBM09aQKdSWXzvLvJg2HkJCleGPX666aH/MYuoHIVIKpAkEA5PTjYyRVSQ3VHXFw1qAdo6knR+KUtt0NADXqccIrHMNjc0itI5kgdNRHv7n+FjK4IAmLbBat6/vpc/5jlGFwvQJAcMxnkVkQ2CJqj1b6rVAbdnezxK8BKEDl/hBkmfo/VSPqu6xNqiRObIoNqDF9gY/2YVRb/2VhTvFpQ4D5I+hNgQJABVsJGp+V8yCEtKybpBmYt+RUC+Vr7x8al7+rHUAafBDB+cdgbW2+iZ0RlJWIMQK8tdsjTML3DIcW/eScdbMVzQJAV4XEjU96b/3IUgnEJJXkX176tG7B/ed3KAVEIXnQ2UAZ5k/YjvuazlZA2k4N5Cr2yrOnSfJUE310GmYDsNwhvQ==",

         'alipay_public_key'=>"MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCnxj/9qwVfgoUh/y2W89L6BkRAFljhNhgPdyPuBV64bfQNN1PjbCzkIM6qRdKBoLPXmKKMiFYnkd6rAoprih3/PrQEB/VsW8OoM8fxn67UDYuyBTqA23MML9q1+ilIZwBC2AQ2UBVOrFXfFl75p6/B5KsiNG9zpgmLCUYuLkxpLQIDAQAB",
        // 'service'=>'mobile.securitypay.pay',
         'service'=>'mobile.securitypay.pay',

        // 'partner'=>'2088821104588355',
        'partner'=>'2088821412482785',

        'input_charset'=>strtolower('utf-8'),
        // '_input_charset'=>'utf-8',
        // 'notify_url'=>'http://yijia.youacloud.com/index.php/goods/order/alipay_notify_url',
        'notify_url'=>'http://yusuzhou.youacloud.com/index.php/shop/zhifu/alipay_notify_url',

        'pay_type'=>1,

        // 'seller_id'=>'1524947025@qq.com',

        // 'cacert'=>getcwd().'/cacert.pem',
        'cacert'=>getcwd()."__ROOT__/extend/Alipay/cacert.pem",

        'transport'=>'http',

        'sign_type'=>strtoupper('RSA'),
    ),


    //=======【微信支付基本信息设置】=====================================
    //
    /**
     * TODO: 修改这里配置为您自己申请的商户信息
     * 微信公众号信息配置
     *
     * APPID：绑定支付的APPID（必须配置，开户邮件中可查看）
     *
     * MCHID：商户号（必须配置，开户邮件中可查看）
     *
     * KEY：商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）
     * 设置地址：https://pay.weixin.qq.com/index.php/account/api_cert
     *
     * APPSECRET：公众帐号secert（仅JSAPI支付的时候需要配置， 登录公众平台，进入开发者中心可设置），
     * 获取地址：https://mp.weixin.qq.com/advanced/advanced?action=dev&t=advanced/dev&token=2005451881&lang=zh_CN
     * @var string
     */

    'wxpay_config'=>array(
        // 'appid'=>'wx6235c82033b914c4',
        // 'mch_id'=>'1490208372',
        // 'key'=>'fasldkfjlajsdflajlsdfjlasd416456',
        // 'appsecret'=>'4e0039c08b08501a63ff374f0836bb4e',
        // 'appsecret'=>'8aa587de2dc997ba29cd4603ff2aa12a',
        // 'notify_url'=>'http://yijia.youacloud.com/index.php/goods/order/weixin_notify_url'
        'appid'=>'wx0578b9d04b418614',
        'mch_id'=>'1493283802',
        // 'key'=>'Mhjfdsklgmkls2549816515555572653',
        'key'=>'n0alu1cnrq8bdus6jcpnnhkig421suz6',
        // 'appsecret'=>'4e0039c08b08501a63ff374f0836bb4e',
        'appsecret'=>'2f320f9215a9ffd641eff3bca88ed441',
        'notify_url'=>'http://yusuzhou.youacloud.com/index.php/shop/zhifu/weixin_notify_url'
    ),
];