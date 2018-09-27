<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2017110509739112",

		//商户私钥
		'merchant_private_key' => "MIIEpAIBAAKCAQEAw9Wh9yFx1qHS8wvNw5tyUhA5kDmttT3ELMXLTRh76inLKhDRKzrvCeCcBaWh8WuISYTUxyPf0e3oLoj9kF7OkMDZbyQn6FTJbEpVNi0uU39xCovwig5ybF1sZUIqfLsd7fZ+92GilMCpOs0mM3J0M99mBrR4zb0Dv3eEgitAsfxJYAC3nVX24omsApJ12rp7Tx50+IPOHFQmILb2fZjkGXBeM9pSS78d7x9DifklMjhY6OPlQ8u/Ktf2Hx8KWxlsklw+PvqwUrjXPcKkH7A8HZXvwLkQGVYqxwFOodwpHPjXydibWg3KGLSg41X1NGvRvWrl4mtGllgzeePCGjPblwIDAQABAoIBAQC1iUQrIwW0QS6bv0VvHppLGF9EIzOz3x4Low9i2F+GIlgDFrPPr0IHlf8L/Q6yDUy5WjkkoUzJ/hBNkw/61OgHp73oGUwlQvO1PvLe1eMr4+eWL0M7t0i6y5+//iYEmjCUdvwbtpZP7ojxyVqwNlkh/OVHMeUKUz02METVpeLDGct0T6tRpelyVYypSzzHbyJAmIYENPvHGMmx7Mcbqy97boGdmmJR+q265RtGVlsaJs4mxQRcB7fcYHANczRBghiOvh0tF5vGX6KJZ6J0XijnZxZ7TgqEn7XdgDjaTSFUv3N69poxRuoi3lMbhuC1pEESV87NQ1Yh8AstocPbNuGBAoGBAPC/QikYCy3malXPSVASmtONWB5SsVPZIsRPiGFFcXkYNyQpq76i074pw1omRVlblBl2Juh3hGHPEvfdk1XUd3JKrhl1BmZhW2rnKSwvoqpkJBzBghnKQP/C2eEREPyfBnwR7lGFUi5QGpW2IxEHeqWzM6jRfw/UGZy8ikfq8GMDAoGBANA97L363svZZ4yukQ+WuIbbNvjgxQ+M7tVmbRyzhqNGIw60PHdKaCw8wDWHF4G9avjM7186qh75591/fhQtaDjpQwckwET2TlnCXSTBmM5ypuTahKy9nHBnpIkqBJFqDdTmDnjbrDA0cNLnx6Oq7qYuHTV+VssQbXWCtKAFWXbdAoGAaqqC+MwjX+HgKUbfV6/2k1bjvQOsd9cT9WC7r0ViYmHdRJOF+cARCwdb+5xLS60ssB9OW99gcymZYOL2fafWiHgYLUVRYZkvNO1Yq7ArZU1bRrZiG2UmaWt+t56lJRiceepD6jCk2co6DS0W2luy9qmwcNLpdizmcDCFIBozCdsCgYEApzEwxI+JFc3lT5RQr11ppgyXJFcCoKucjgWAkUyqSqjjOMkIyxYYcXwNLmzaOLZmDoArqB+nutsWiEX2aijSxu6xfCjLnhLLcVGWCw7MquRujsvLPg22bqEn/2CW7lFh7Y8QC4UDyGgyNYMWTJfOp+naVbqr4Lm9yF06vEfPPpkCgYBFqPuv+y2yYjLsyreywKStU5w31uAwsIH7UkF/z6p4KMWb2qOzsfC+G2fVELDDp+4EnkfFgupvPBQLXMTeRgipfqVp7YJqWmpWfh+7rcEKqC3fsBXQliRqkHZHdTb6Hm0Ljp7nY5NS6IUhA/y93lzV1A/OMRbS2zeGJolmzIUmGQ==",
		
		//异步通知地址
		// 'notify_url' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/notify_url.php",
		'notify_url' => "http://www.jiayuhua.net/home/Payment/AliNotifyUrl",
		
		//同步跳转
		// 'return_url' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/return_url.php",
		'return_url' => "http://www.jiayuhua.net/home/Payment/AliReturnUrl",
		
		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApCKwa6BJut4+j92y9spt8PwSKMgfhdDQNKyH0/3Ug0zaCbiKkHW3eN6DauQNrv3KhV6c4CU64dGtorURk3xowOFyZvziOzJRFvrdZmwY9nvLuA0BtPWto/kikcIfznnYNHc1Fd8ajTL3qxsS7zB5A559bRiw3n1TaY2SAMdIGCvlPwIhBjLmeKl7ip6CD/YAYxEGCgO6pzmST8/l8NfdP/hyk+gG6XGonE0uO7JFsFDMA8+BQGzeurh5XFbnzmgxawKqKJ0MbcrJyzQyKMSr/Emguck/b9AQNvpRKeiuvhPOoKYAca8WXqt1dvVXRTnDpmP7J+AGs6u7G5gN515IgQIDAQAB",
);