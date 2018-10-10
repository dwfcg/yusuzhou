<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/8
 * Time: 16:43
 */
namespace app\auction\validate;
use think\Validate;
class Kill extends Validate
{
    protected $scene = [

        //更新
        'update'  =>  ['name'=>['require'], 'price','start_time','end_time'],

    ];

// 验证规则
    protected $rule = [
        ['title', 'require|unique:auction_kill'],
        ['price', 'require|gt:0|number'],
        ['start_time', 'require|checkSendTime'],
        ['end_time', 'require'],
    ];
    //错误信息
    protected $message  = [
        'title.require'                  => '秒杀商品名称必填',
        'title.unique'                   => '已有相同秒杀商品名称',
        'price.require'                 => '请填写秒杀商品价格',
        'price.number'                 => '价格必须是数字',
        'price.gt'                      => '价格必须是大于0的数',
        'start_time.require'       => '开始日期',
        'start_time.checkSendTime' => '结束日期不得小于开始日期',

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
}