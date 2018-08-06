<?php

namespace app\home\model;

use think\Model;

class Member extends Model
{
    //主键
    protected $pk = 'member_id';
    //时间戳自动维护
    protected $autoWriteTimestamp = true;

    //事件
    protected static function init() {
        Member::event('before_insert', function($member) {
            $member['password'] = md5($member['password'].config('password_salt'));
        });
    }

    //检查输入的用户名和密码是否正确
    public function checkuser($username, $password){
        $where = [
            'username' => $username,
            'password' => md5($password.config('password_salt')),
        ];
        $userInfo = $this->where($where)->find();
        if ($userInfo) {
            //验证正确,记入到session中
            session('member_id', $userInfo['member_id']);
            session('username', $userInfo['username']);
            return true;
        }else {
            return false;
        }
    }
}
