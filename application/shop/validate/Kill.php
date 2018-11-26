<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/1
 * Time: 17:06
 */
namespace app\shop\validate;
use think\Validate;


class Kill extends  Validate
{
    // 验证规则
    protected $rule = [
        ['start_time', 'require|checkSendTime'],
        ['end_time', 'require'],
        ['s', 'require'],
    ];
    //错误信息
    protected $message  = [

        'start_time.require'       => '请选择发放开始日期',
        's.require'       => '分类必须填写',
        'start_time.checkSendTime' => '发放结束日期不得小于发放开始日期',
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
        return ($value >= $data['end_time']) ? false : true;
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
}