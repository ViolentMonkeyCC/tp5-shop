<?php

namespace app\home\controller;

use app\home\model\Member;
use think\Controller;

class PublicController extends Controller
{
    //前台注册页面
    public function register(){
        //1.判断是否是post提交
        if (request()->isPost()) {
            //2.接受提交的参数
            $postData = input('post.');
            //3.验证器数据
            $result = $this->validate($postData, 'MemberValidate.register', [], true);
            if ($result !== true) {
                //验证失败, 输出提示信息
                $this->error(implode(',', $result));
            }
            //判断用户输入的手机验证码是否正确
            if (md5($postData['phoneCaptcha'].config('sms_salt')) !== cookie('phone')) {
                $this->error('手机验证码不正确!');
            }
            //4.判断是否入库成功
            $memberModel = new Member();
            if ($memberModel->allowField(true)->save($postData)) {
                cookie('phone', null);//注册成功后删除cookie
                $this->success('注册成功!', url('/'));
            }else {
                $this->error('注册失败!');
            }
        }
        
        return $this->fetch();
    }

    //前台登录页面
    public function login(){
        //1.判断是否是post提交
        if (request()->isPost()) {
            //2.接受提交的参数
            $postData = input('post.');
            //3.验证器数据
            $result = $this->validate($postData, 'MemberValidate.login', [], true);
            if ($result !== true) {
                //验证失败, 输出提示信息
                $this->error(implode(',', $result));
            }
            //4.验证数据
            $memberModel = new Member();
            $result = $memberModel->checkUser($postData['username'], $postData['password']);
            if ($result) {
                $this->success('登录成功!', url('/'));
            }else {
                $this->error('账号或密码错误!');
            }
        }

        return $this->fetch();
    }

    //前台退出页面
    public function logout(){
        //删除当前的session即可
        session('member_id', null);
        session('username', null);
        //重定向到前台首页
        $this->redirect('/');
    }

    //注册页面发送短信验证码
    public function SendSms(){
        //判断是否是ajax请求
        if (request()->isAjax()) {
            //接收参数
            $phone = input('phone');
            //验证手机号是否被注册过
            $result = Member::where('phone', $phone)->select()->toArray();
            if ($result) {
                //用户已经注册过
                $reponse = ['code' => -1, 'message' => '该手机号码已注册!'];
                echo json_encode($reponse);die;
            }
            //发送短信
            //随机验证码
            $rand = mt_rand(1000, 9999);
            $result = sendSMS($phone, array($rand, 5), '1');
            if ($result->statusCode == '000000') {
                //发送成功
                //给手机验证码加盐,存储到cookie中,用于和用户输入的作比较
                cookie('phone', md5($rand.config('sms_salt')), 300);//300有效时间5分钟(300秒)
                $reponse = ['code' => 200, 'message' => '发送短信成功!'];
                echo json_encode($reponse);die;
            }else {
                $reponse = ['code' => -2, 'message' => '网络异常请重试或'.$result->statusMsg];
                echo json_encode($reponse);die;
            }
        }
    }
}
