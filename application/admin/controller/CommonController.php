<?php

namespace app\admin\controller;

use think\Controller;

class CommonController extends Controller
{
    //实现防翻墙技术
    protected function _initialize() {
        //判断是否有session
        if (!session('user_id')) {
            //没有session则提示用户登录
            $this->success('登录后再试', url('/admin/public/login'));
        }else {
            //登录没有翻墙, 可能是权限翻墙
            //获取session 中的权限
            $visitorAuth = session('visitorAuth');
            //1.拼接获取当前访问的控制器名及方法名,转为小写
            $now_ca = strtolower(request()->controller().'/'.request()->action());
            //2.判断访问的权限是否在session所记录的权限中存在
            //2-1.超级管理员 不做权限控制,直接放行, 或存在index控制器也放行
            if ($visitorAuth == '*' || strtolower(request()->controller()) == 'index') {
                return;
            }
            //2-2.非超级管理员
            if (!in_array($now_ca, $visitorAuth)) {
//                exit('访问错误');
                $this->error('访问错误');
            }
        }
    }
}
