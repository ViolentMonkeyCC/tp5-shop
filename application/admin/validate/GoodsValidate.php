<?php
/**
 * Created by PhpStorm.
 * User: 城晨
 * Date: 2018/8/3
 * Time: 19:30
 */

namespace app\admin\validate;

use think\Validate;

class GoodsValidate extends Validate
{
    //验证规则
    protected $rule = [
        'goods_name' => 'require|unique:goods',
        'goods_price' => 'require|gt:0',
        'goods_number' => 'require|regex:\d+',
        'cat_id' => 'require',
    ];

    //错误提示信息
    protected $message = [
        'goods_name.require' => '商品名称必填!',
        'goods_name.unique' => '商品名称重复!',
        'goods_price.require' => '商品价格必填!',
        'goods_price.gt' => '商品价格需大于0!',
        'goods_number.require' => '库存必填!',
        'goods_number.regex' => '库存需大于0!',
        'cat_id.require' => '请选择商品分类!',
    ];

    //验证场景
    protected $scene = [
        'add' => ['goods_name', 'goods_price', 'goods_number', 'cat_id'],
    ];
}