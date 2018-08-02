<?php
/**
 * Created by PhpStorm.
 * User: 城晨
 * Date: 2018/8/2
 * Time: 11:22
 */

namespace app\admin\validate;

use think\Validate;

class AttributeValidate extends Validate
{
    //验证规则
    protected $rule = [
        'attr_name' => 'require|unique:attribute',
        'type_id' => 'require',
        'attr_values' => 'require',
    ];

    //错误提示信息
    protected $message = [
        'attr_name.require' => '属性名称必填',
        'attr_name.unique' => '属性名称重复',
        'type_id.require' => '商品类型必填!',
        'attr_values.require' => '属性值必填!',
    ];

    //验证场景
    protected $scene = [
        'add' => ['attr_name', 'type_id', 'attr_values'],
        'except_attr_values' => ['attr_name', 'type_id'],
        'upd' => ['attr_name', 'type_id', 'attr_values'],
    ];
}