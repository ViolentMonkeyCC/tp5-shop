<?php

namespace app\admin\controller;

use app\admin\model\Auth;
use app\admin\model\Role;
use think\Db;

class RoleController extends CommonController
{
    //角色分配删除页
    public function del()
    {
        //1.接收参数
        $role_id = input('role_id');
        //判断是否删除成功
        if (Role::destroy($role_id)) {
            $this->success('删除成功!', url('/admin/role/index'));
        } else {
            $this->error('删除失败!');
        }
    }

    //角色分配编辑页
    public function upd(){
        //1.判断是否是post提交
        if (request()->isPost()) {
            //2.接受提交的参数
            $postData = input('post.');
            //3.验证器数据
            $result = $this->validate($postData, 'RoleValidate.upd', [], true);
            if ($result !== true) {
                //验证失败, 输出提示信息
                $this->error(implode(',', $result));
            }
            //4.判断是否入库成功
            $roleModel = new Role();
            if ($roleModel->update($postData)) {
                $this->success('添加成功!', url('admin/role/index'));
            }else {
                $this->error('添加失败!');
            }
        }

        $role_id = input('role_id');
        //取出所有的权限
        $oldAuths = Auth::select()->toArray();
        //两个技巧
        //1.以每个权限的auth_id作为$oldAuths二维数组的下标
        $auths = [];
        foreach ($oldAuths as $v) {
            $auths[$v['auth_id']] = $v;
        }
        //2.根据pid进行分组, 把具有相应的pid分为同一组
        $children = [];
        foreach ($oldAuths as $vv) {
            $children[$vv['pid']][] = $vv['auth_id'];
        }
        //取出当前角色已有的权限
        $role = Role::find($role_id);
        return $this->fetch('',[
            'role' => $role,
            'auths' => $auths,
            'children' => $children,
        ]);
    }

    //角色分配列表页
    public function index(){
        $roles = Db::query("select t1.*, GROUP_CONCAT(t2.auth_name) as all_auth from sh_role t1 left join sh_auth t2 on FIND_IN_SET(t2.auth_id, t1.auth_ids_list) group by t1.role_id");
        return $this->fetch('', ['roles' => $roles]);
    }

    //角色添加页
    //权限添加页
    public function add()
    {
        //1.判断是否是post提交
        if (request()->isPost()) {
            //2.接受提交的参数
            $postData = input('post.');
            //3.验证器数据
            $result = $this->validate($postData, 'RoleValidate.add', [], true);
            if ($result !== true) {
                //验证失败, 输出提示信息
                $this->error(implode(',', $result));
            }
            //4.判断是否入库成功
            $roleModel = new Role();
            if ($roleModel->allowField(true)->save($postData)) {
                $this->success('添加成功!', url('admin/role/index'));
            }else {
                $this->error('添加失败!');
            }
        }

        $authModel = new Auth();
        //显示权限数据
        $oldData = $authModel->select()->toArray();

        //1.将权限表的auth_id作为二维数组的下标
        $auths = [];
        foreach ($oldData as $v) {
            $auths[$v['auth_id']] = $v;
        }

        //2.把所有的权限以pid进行分组
        $children = [];
        foreach ($oldData as $v) {
            $children[$v['pid']][] = $v['auth_id'];
        }

        return $this->fetch('', ['auths' => $auths, 'children' => $children]);
    }
}
