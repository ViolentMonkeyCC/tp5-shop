<?php
/**
 * Created by PhpStorm.
 * User: 城晨
 * Date: 2018/8/2
 * Time: 16:11
 */


namespace app\admin\validate;

use think\Validate;

class CategoryValidate extends Validate
{
    //验证规则
    protected $rule = [
        'cat_name' => 'require|unique:category',
        'pid' => 'require',
    ];

    //错误提示信息
    protected $message = [
        'cat_name.require' => '分类名称必填!',
        'cat_name.unique' => '分类名称重复!',
        'pid.require' => '所属父分类必填!',
    ];

    //验证场景
    protected $scene = [
        'add' => ['cat_name', 'pid'],
        'upd' => ['cat_name', 'pid'],
    ];
}