<?php
/**
 * Created by PhpStorm.
 * User: 城晨
 * Date: 2018/8/2
 * Time: 10:44
 */


namespace app\admin\validate;

use think\Validate;

class TypeValidate extends Validate
{
    //验证规则
    protected $rule = [
        'type_name' => 'require|unique:type',
    ];

    //错误提示信息
    protected $message = [
        'type_name.require' => '类型名称必填!',
        'type_name.unique' => '类型名称重复!',
    ];

    //验证场景
    protected $scene = [
        'add' => ['type_name'],
    ];
}