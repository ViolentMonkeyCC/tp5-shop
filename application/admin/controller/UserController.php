<?php

namespace app\admin\controller;

use app\admin\model\Role;
use app\admin\model\User;

class UserController extends CommonController
{
    //用户添加页
    public function add(){
        //1.判断是否是post提交
        if (request()->isPost()) {
            //2.接受提交的参数
            $postData = input('post.');
            //3.验证器数据
            $result = $this->validate($postData, 'UserValidate.add', [], true);
            if ($result !== true) {
                //验证失败, 输出提示信息
                $this->error(implode(',', $result));
            }
            //4.判断是否入库成功
            $userModel = new User();
            if ($userModel->allowField(true)->save($postData)) {
                $this->success('添加成功!', url('admin/user/index'));
            }else {
                $this->error('添加失败!');
            }
        }

        //取出所有的角色数据,分配到模板中
        $roles = Role::select()->toArray();
        return $this->fetch('', ['roles' => $roles]);
    }
    
    //用户列表页
    public function index(){
        //回显数据
        $userModel = new User();
        $users = $userModel->field('t1.*, t2.role_name')
            ->alias('t1')
            ->join('sh_role t2', 't1.role_id=t2.role_id', 'left')
            ->paginate(3);
        return $this->fetch('', ['users' => $users, 'count' => User::count()]);
    }

    //用户编辑页
    public function upd(){
        $userModel = new User();
        //1.判断是否是post提交
        if (request()->isPost()) {
            //2.接收参数
            $postData = input('post.');
            //halt($postData);
            //3.验证器验证数据
            //用户的密码留空表示不修改密码,否则修改密码
            if ($postData['password'] == '' && $postData['repassword'] == '') {
                //不修改密码, 只需要验证用户名不为空即可
                $result = $this->validate($postData, 'UserValidate.OnlyUsername', [], true);
                if ($result !== true) {
                    $this->error(implode(',', $result));
                }
            }else {
                //修改密码
                $result = $this->validate($postData, 'UserValidate.UsernamePassword', [], true);
                if ($result !== true) {
                    $this->error(implode(',', $result));
                }
            }

            //判断入库是否成功
            if ($userModel->allowField(true)->isUpdate(true)->save($postData)) {
                $this->success('编辑成功!', url('/admin/user/index'));
            }else {
                $this->error('编辑失败!');
            }

        }

        //回显数据
        //接收参数
        $user_id = input('user_id');
        $userData = $userModel->find($user_id);
        //取出所有的角色数据,分配到模板中
        $roles = Role::select()->toArray();
        return $this->fetch('', ['userData' => $userData, 'roles' => $roles]);
    }
    
    //用户删除页
    public function del(){
        //1.接收参数
        $user_id = input('user_id');
        //判断是否删除成功
        if (User::destroy($user_id)) {
            $this->success('删除成功!', url('/admin/user/index'));
        }else {
            $this->error('删除失败!');
        }
        
    }

}
