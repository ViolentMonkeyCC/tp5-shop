<?php

namespace app\admin\controller;

use app\admin\model\Auth;
use App\Models\Role;

class RoleController extends CommonController
{
    //角色添加页
    //权限添加页
    public function add()
    {
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
