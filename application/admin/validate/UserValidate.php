<?php
/**
 * Created by PhpStorm.
 * User: 城晨
 * Date: 2018/7/29
 * Time: 19:42
 */

namespace app\admin\validate;

use think\Validate;

class UserValidate extends Validate
{
    //1.验证规则
    protected $rule = [
        'username' => 'require|unique:user',
        'password' => 'require|min:5',
        'repassword' => 'require|confirm:password',
    ];
    //2.验证错误提示信息
    protected $message = [
        'username.require' => '用户名必填!',
        'username.unique' => '用户名重复!',
        'password.require' => '密码必填!',
        'password.min' => '密码最短5位!',
        'repassword.require' => '确认密码必填!',
        'repassword.confirm' => '两次输入不一致!',
    ];
    //3.验证场景
    protected $scene = [
        'login' => ['username' => 'require', 'password'],
        'add' => ['username', 'password', 'repassword'],
        'OnlyUsername' => ['username' => 'require'],
        'UsernamePassword' => ['username' => 'require', 'password', 'repassword'],
    ];
}