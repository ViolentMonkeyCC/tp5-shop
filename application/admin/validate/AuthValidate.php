<?php
/**
 * Created by PhpStorm.
 * User: 城晨
 * Date: 2018/7/31
 * Time: 19:09
 */

namespace app\admin\validate;

use think\Validate;

class AuthValidate extends Validate
{
    //1.验证规则
    protected $rule = [
        'auth_name' => 'require|unique:auth',
        'pid' => 'require',
        'auth_a' => 'require',
        'auth_c' => 'require',
    ];
    //2.验证错误提示信息
    protected $message = [
        'auth_name.require' => '权限名必填!',
        'auth_name.unique' => '权限名重复!',
        'pid.require' => '父级权限必填!',
        'auth_a.require' => '控制器名必填!',
        'auth_c.require' => '方法名必填!',
    ];
    //3.验证场景
    protected $scene = [
        'add' => ['auth_name', 'pid', 'auth_a', 'auth_c'],
        'upd' => ['auth_name' => 'require', 'pid', 'auth_a', 'auth_c'],
        'onlyAuthName' => ['auth_name' => 'require'],
    ];
}