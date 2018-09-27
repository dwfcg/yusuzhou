<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站：http://dolphinphp.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | 作者: 蔡伟明 <314013107@qq.com>
// +----------------------------------------------------------------------

// [ PHP版本检查 ]
header("Content-type: text/html; charset=utf-8");
header("Access-Control-Allow-Origin: *");
// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');

// 定义后台入口文件
define('ADMIN_FILE', 'admin.php');
//定义session保存目录
// define('SESSION_PATH',__DIR__.'./runtime/session/');
// 检查是否安装
if(!is_file('./data/install.lock')){
    define('BIND_MODULE', 'install');
}

// 加载框架引导文件
require './thinkphp/start.php';
