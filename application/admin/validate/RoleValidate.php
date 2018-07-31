<?php
/**
 * Created by PhpStorm.
 * User: 城晨
 * Date: 2018/7/31
 * Time: 21:37
 */


namespace app\admin\validate;

use think\Validate;

class RoleValidate extends Validate
{
    //验证规则
    protected $rule = [
        'role_name' => 'require|unique:role',
    ];

    //错误提示信息
    protected $message = [
        'role_name.require' => '角色名称必填!',
        'role_name.unique' => '角色名称重复!',
    ];

    //验证场景
    protected $scene = [
        'add' => 'role_name',
    ];
}