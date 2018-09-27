<?php
namespace app\forum\validate;

use think\Validate;

class Thread extends Validate
{
    protected $rule = [
        'uid' => 'require',
        'title'  => 'require',
        'content'   => 'require',

    ];
    protected $msg = [
        'uid.require' => '用户未登录',
        'title.require' => '请输入帖子标题',
        'content.require' => '请输入帖子内容',    
    ];

}