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

    //判断用户是否登录成功
    public function checkLogin($userName, $password){
        $where = [
            'username' => $userName,
            'password' => md5($password.config('password_salt')),
        ];
        $userInfo = $this->where($where)->find();
        if ($userInfo) {
            session('user_id', $userInfo['user_id']);
            session('username', $userInfo['username']);
            //通过用户的角色role_id,把当前用户的权限写入到session中
            $this->getAuthWriteSession($userInfo['role_id']);
            return true;
        }else {
            return false;
        }
    }


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

    protected function getAuthWriteSession($role_id) {
        //获取角色表中的auth_ids_list字段的值
        $auth_ids_list = Role::where('role_id', $role_id)->value('auth_ids_list');
        //如果是超级管理用户 $auth_ids_list => *
        if ($auth_ids_list == '*') {
            //超级管理员用户拥有权限表所有数据
            $oldAuths = Auth::select()->toArray();
        }else {
            //如果是非超级管理员只能取出已有的权限, $auth_ids_list => 1,2,3,4
            $oldAuths = Auth::where('auth_id', 'in', $auth_ids_list)->select()->toArray();
        }

        //两个技巧取出数据
        //1.每个数组的auth_id作为二维数组的下标
        $auths = [];
        foreach ($oldAuths as $v) {
            $auths[$v['auth_id']] = $v;
        }

        //2.通过pid进行分组
        $children = [];
        foreach ($oldAuths as $vv) {
            $children[$vv['pid']][] = $vv['auth_id'];
        }

        //写入到session中去
        session('auths', $auths);
        session('children', $children);
        //写入管理员可访问的权限到session中去, 用于防翻墙
        if ($auth_ids_list == '*'){
            //超级管理员
            session('visitorAuth', '*');
        }else {
            //非超级管理员
            $visitorAuth = [];
            foreach($oldAuths as $v) {
                $visitorAuth[] = strtolower($v['auth_c'].'/'.$v['auth_a']);
            }
            session('visitorAuth', $visitorAuth);
        }
    }
}