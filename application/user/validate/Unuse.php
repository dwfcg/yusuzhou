<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/25
 * Time: 17:18
 */

namespace app\user\validate;


use think\Validate;

class Unuse extends Validate
{
    protected $rule = [
        'name|用户名' => 'require',
        'comment|描述'  => 'require',
        'images|图片'      => 'require',
        'user_id|用户ID'     => 'require',
        'price|价格'  => 'require|number',
        'ipone|手机号'   => 'regex:^1\d{10}|require',
        'express|快递名称'   => 'require',
        'express_no|快递单号'   => 'require|number',
    ];
    //定义验证提示
    protected $message = [

    ];
    protected $scene = [
        'applyunuse'  =>  ['name', 'comment', 'images', 'user_id', 'price', 'ipone'],
        'getexpress'  =>  ['express', 'express_no','user_id'],
    ];
}