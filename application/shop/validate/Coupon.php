<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/8
 * Time: 16:43
 */
namespace app\shop\validate;
use think\Validate;
class Coupon extends Validate
{
    //定义验证规则

//    protected $rule = [
//
//        'name|优惠券名字' => 'require',
//        'money|优惠券金额' => 'require',
//        'condition|消费金额' => 'require',
//        'createnum|发放数量' => 'require',
//        'send_start_time|发放开始时间' => 'require',
//        'send_end_time|发放结束时间' => 'require',
//        'send_start_time|使用开始时间' => 'require',
//        'send_end_time|使用结束时间' => 'require',
//    ];
//定义验证场景

    protected $scene = [

        //更新
        'update'  =>  ['name'=>['require'], 'money','condition','createnum','type','send_start_time','send_end_time','use_start_time'],

    ];

// 验证规则
    protected $rule = [
        ['name', 'require|unique:shop_coupon,name^type'],
        ['money', 'require|gt:0|number'],
        ['condition', 'require|gt:0|checkCondition|number'],
        ['createnum', 'require|number'],
        ['type', 'require'],
        ['send_start_time', 'require|checkSendTime'],
        ['send_end_time', 'require'],
        ['use_start_time', 'checkUserTime'],
    ];
    //错误信息
    protected $message  = [
        'name.require'                  => '优惠券名称必填',
        'name.unique'                   => '已有相同类型的优惠券名称',
        'money.require'                 => '请填写优惠券面额',
        'money.number'                 => '优惠券面额必须是数字',
        'money.gt'                      => '优惠券面额必须是大于0的数',
        'condition.require'             => '请填写消费金额',
        'condition.gt'                  => '请填写消费金额是大于0的数',
        'condition.checkCondition'      => '消费金额不能小于或等于优惠券金额',
        'createnum.require'             => '请填写发放数量',
        'type.require'                  => '请选择发放类型',
        'send_start_time.require'       => '请选择发放开始日期',
        'send_start_time.checkSendTime' => '发放结束日期不得小于发放开始日期',
        'send_end_time.require'         => '请选择发放结束日期',
        'use_start_time.checkUserTime' => '使用结束日期不得小于使用开始日期',
    ];
    /**
     * 检查发放日期
     * @param $value|验证数据
     * @param $rule|验证规则
     * @param $data|全部数据
     * @return bool|string
     */
    protected function checkSendTime($value, $rule ,$data)
    {
        return ($value >= $data['send_end_time']) ? false : true;
    }

    /**
     * 检查用户使用时间
     * @param $value
     * @param $rile
     * @param $data
     * @return bool
     */
    protected function checkUserTime($value,$rile,$data){
        return ($value >= $data['use_end_time']) ? false : true;
    }
    /**
     * 检查消费金额
     * @param $value|验证数据
     * @param $rule|验证规则
     * @param $data|全部数据
     * @return bool|string
     */
    protected function checkCondition($value, $rule ,$data)
    {
        return ($value < $data['money']) ? false : true;
    }

    //定义验证提示
//
//    protected $message = [
//
////        'send_end_time.require' => '请输入用户名',
//
//    ];





}