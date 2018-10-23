<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/11
 * Time: 17:07
 */

namespace app\user\validate;


use think\Validate;

class Ship  extends Validate
{
    //定义验证规则
    protected $rule = [
        'name|会员名称' => 'require|unique:user_ship',
        'condition|会员条件'  => 'require|number',
        'level|会员等级'      => 'require|number|unique:user_ship',
        'discount|会员折扣'     => 'require|number',
    ];
//    //定义验证提示
//    protected $message = [
//        'username.require' => '请输入用户名',
//        'email.require'    => '邮箱不能为空',
//        'email.email'      => '邮箱格式不正确',
//        'email.unique'     => '该邮箱已存在',
//        'password.require' => '密码不能为空',
//        'password.length'  => '密码长度6-20位',
//        'mobile.regex'     => '手机号不正确',
//    ];
//    //定义验证场景
    protected $scene = [
        'update'  =>  ['name'=>['require'],'condition','level','discount'],
    ];
}