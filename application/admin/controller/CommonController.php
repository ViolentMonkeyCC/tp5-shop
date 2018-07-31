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
        }
    }
}
