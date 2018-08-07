<?php
/**
 * Created by PhpStorm.
 * User: 城晨
 * Date: 2018/8/6
 * Time: 21:36
 */

namespace app\home\validate;

use think\Validate;

class MemberValidate extends Validate
{
    //验证规则
    protected $rule = [
        'username' => 'require|unique:member',
        'email' => 'require|email|unique:member',
        'password' => 'require',
        'repassword' => 'require|confirm:password',
        'captcha' => 'require|captcha',
        'login_captcha' => 'require|captcha:2',
        'phone' => 'require|unique:member',
    ];

    //错误提示信息
    protected $message = [
        'username.require' => '用户名必填!',
        'username.unique' => '用户名重复!',
        'email.require' => '邮箱必填!',
        'email.unique' => '邮箱已被注册!',
        'email.email' => '邮箱格式非法!',
        'password.require' => '密码必填!',
        'repassword.require' => '确认密码必填!',
        'repassword.confirm' => '两次密码不一致!',
        'captcha.require' => '验证码必填!',
        'captcha.captcha' => '验证码错误!',
        'login_captcha.require' => '验证码必填!',
        'login_captcha.captcha' => '验证码错误!',
        'phone.require' => '手机号码必填!',
        'phone.unique' => '此号码已注册!',

    ];

    //验证场景
    protected $scene = [
        'register' => ['username', 'email', 'password', 'repassword', 'captcha','phone'],
        'login' => ['username' => 'require', 'password', 'login_captcha'],
        'setNewPassword' => ['password', 'repassword'],
    ];
}