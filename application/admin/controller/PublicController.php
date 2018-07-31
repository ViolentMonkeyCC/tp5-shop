<?php

namespace app\admin\controller;

use app\admin\model\User;
use think\Controller;

class PublicController extends Controller
{
    //登录页面
    public function login(){
        //1.判断是否是post提交
        if (request()->isPost()) {
            //接收数据
            $postData = input('post.');
            // 验证数据
            $result = $this->validate($postData, 'UserValidate.login', [], true);
            if ($result !== true) {
                $this->error(implode(',', $result));
            }
            //判断数据是否入库成功
            $userModel = new User();
            if ($userModel->checkLogin($postData['username'], $postData['password'])) {
                $this->redirect(url('/'));
            }else {
                $this->error('账号或者密码错误!');
            }
        }
        return $this->fetch();
    }

    //退出页面
    public function logout(){
        //清除session
        session(null);
        $this->redirect(url('/admin/public/login'));
    }
}
