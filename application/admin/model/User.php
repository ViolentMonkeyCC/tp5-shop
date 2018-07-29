<?php
/**
 * Created by PhpStorm.
 * User: 城晨
 * Date: 2018/7/29
 * Time: 19:57
 */

namespace app\admin\model;

use think\Model;

class User extends Model
{
    //主键
    protected $pk = 'user_id';
    //时间戳自动维护
    protected $autoWriteTimestamp = true;

    //时间处理方法
    protected static function init() {
        //入库前的事件before_insert 新增
        User::event('before_insert', function ($user) {
            //halt($user);
            $user['password'] = md5($user['password']. config('password_salt'));
        });

        //新增前的事件before_update 更新
        User::event('before_update', function ($user) {
            if ($user['password'] == ''){
                unset($user['password']);
            }else {
                $user['password'] = md5($user['password']. config('password_salt'));
            }
        });

    }
}