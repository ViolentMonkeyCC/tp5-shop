<?php

namespace app\admin\controller;

use app\admin\model\Auth;

class AuthController extends CommonController
{
    //权限添加页
    public function add(){
        $authModel = new Auth();
        //1.判断是否是post提交
        if (request()->isPost()) {
            //2.接受提交的参数
            $postData = input('post.');
            //3.验证器数据
            if ($postData['pid'] == 0) {
                $result = $this->validate($postData, 'AuthValidate.onlyAuthName', [], true);
            }else {
                $result = $this->validate($postData, 'AuthValidate.add', [], true);
            }
            if ($result !== true) {
                //验证失败, 输出提示信息
                $this->error(implode(',', $result));
            }
            //4.判断是否入库成功
            if ($authModel->allowField(true)->save($postData)) {
                $this->success('添加成功!', url('admin/auth/index'));
            }else {
                $this->error('添加失败!');
            }
        }

        //无限极递归
        $authData = $authModel->select()->toArray();
        $auths = $authModel->getSonsCats($authData);
        return $this->fetch('', ['auths' => $auths]);
    }

    //权限列表页
    public function index(){
        //1.回显数据
        $authModel = new Auth();
        $authData = $authModel->field('t1.*, t2.auth_name a_name')
            ->alias('t1')
            ->join('sh_auth t2', 't1.pid = t2.auth_id', 'left')
            ->select()
            ->toArray();
        //2.无限极回显数据
        $auths = $authModel->getSonsCats($authData);
        return $this->fetch('', ['count' => $authModel->count(), 'auths' => $auths]);
    }

    //权限编辑页
    public function upd(){
        $authModel = new Auth();
        //1.判断是否是post提交
        //检查是否写了隐藏域
        if (request()->isPost()) {
            //2.接受提交的参数
            $postData = input('post.');
            //3.验证器数据
            if ($postData['pid'] == 0) {
                $result = $this->validate($postData, 'AuthValidate.onlyAuthName', [], true);
            }else {
                $result = $this->validate($postData, 'AuthValidate.upd', [], true);
            }
            if ($result !== true) {
                //验证失败, 输出提示信息
                $this->error(implode(',', $result));
            }
            //4.判断是否入库成功
            if ($authModel->update($postData)) {
                $this->success('添加成功!', url('admin/auth/index'));
            }else {
                $this->error('添加失败!');
            }
        }

        //接收数据并回显数据
        $auth_id = input('auth_id');
        $atData = $authModel->find($auth_id);
        $authData = $authModel->select()->toArray();
        //无限递归
        $auths = $authModel->getSonsCats($authData);
        return $this->fetch('', ['atData' => $atData, 'auths' => $auths]);

    }

    //权限删除页
    public function del(){
        //1.接收参数
        $auth_id = input('auth_id');
        //判断是否删除成功
        if (Auth::destroy($auth_id)) {
            $this->success('删除成功!', url('/admin/auth/index'));
        }else {
            $this->error('删除失败!');
        }
    }


}
