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

    //忘记密码页面
    public function forgetPassword(){
        return $this->fetch('public/forgetpassword');
    }

    //ajax发送邮件
    public function sendEmail(){
        //1.判断是否是ajax请求
        if (request()->isAjax()) {
            //接收参数
            $email= input('email');
            //查询数据库中是否有,如果有则发送邮件,没有就不发送
            $result = Member::where('email', $email)->find()->toArray();
            if (!$result) {
                //不存在此邮箱
                $response = ['code' => -1, 'message' => '您输入的邮箱不存在!'];
                echo json_encode($response);die;
            }
            $member_id = $result['member_id'];
            $time = time();
            $hash = md5($member_id.$time.config('email_salt'));
            $href = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/home/public/setNewPassword/".$member_id."/".$time."/".$hash;
            $content = "<a href='{$href}' target='_blank'>京西商城-找回密码</a>";
            //发送邮件
            if ( sendEmail([$email], '找回密码', $content) ) {
                $response = ['code' => 200, 'message' => '发送成功,请登录邮箱查看!'];
                echo json_encode($response);die;
            }else {
                $response = ['code' => -2, 'message' => '发送失败,请稍后重试!'];
                echo json_encode($response);die;
            }
        }
    }

    //重置新密码路由
    public function setNewPassword($member_id, $time, $hash){
        //判断邮件地址是否被篡改, 判断hash加密字符串的结果, 不一样则被篡改
        if (md5($member_id.$time.config('email_salt')) != $hash){
            exit('你对地址做了啥?');
        }
        //判断是否在有效期内30分钟
        if (time() > $time+1800) {
            exit('链接已失效!');
        }
        if (request()->isPost()){
            $postData = input('post.');
            $result = $this->validate($postData, 'MemberValidate.setNewPassword', [], true);
            if ($result !== true) {
                $this->error(implode(',', $result));
            }
            //更新密码
            $data = [
                'member_id' => $member_id,
                'password' => md5($postData['password'].config('password_salt'))
            ];
            $memModel = new Member();
            if ($memModel->update($data)) {
                $this->success('重置密码成功!', url('home/public/login'));
            }else {
                $this->error('重置失败!');
            }
        }
        return $this->fetch('public/setnewpassword');
    }
}
