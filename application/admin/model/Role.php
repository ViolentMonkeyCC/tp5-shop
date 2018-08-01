<?php
/**
 * Created by PhpStorm.
 * User: 城晨
 * Date: 2018/7/31
 * Time: 21:32
 */

namespace app\admin\model;

use think\Model;

class Role extends Model
{
    //主键
    protected $pk = 'role_id';
    //时间戳自动维护
    protected $autoWriteTimestamp = true;

    //事件处理
    protected static function init() {
        //入库前的事件
        Role::event('before_insert', function ($role) {
            if (isset($role['auth_ids_list'])) {
                $role['auth_ids_list'] = implode(',', $role['auth_ids_list']);
            }
        });

        //更新前的事件
        Role::event('before_update', function ($role) {
            //把权限数组形式变为字符串进行入库
            //防止没有分配权限没有auth_ids_list属性导致保存
            if (isset($role['auth_ids_list'])) {
                $role['auth_ids_list'] = implode(',', $role['auth_ids_list']);
            }
        });
    }

}