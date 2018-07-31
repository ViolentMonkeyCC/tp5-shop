<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/*return [
   __pattern__' => [
       'name' => '\w+',
   ],
   '[hello]'     => [
       ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
       ':name' => ['index/hello', ['method' => 'post']],
   ],

];*/

use think\Route;

/*//定义路由规则
Route::get('/', 'index/index/index');
Route::get('login/[:id]', 'index/index/login');//[:id]可省参数*/
Route::get('/', 'admin/index/index');
//后台路由
Route::group('admin', function () {
    /**********************首页展示路由*************************/
    Route::get('index/left', 'admin/index/left'); //admin/index/left
    Route::get('index/top', 'admin/index/top');
    Route::get('index/main', 'admin/index/main');

    /**********************后台用户登录/退出 路由*************************/
    Route::any('public/login', 'admin/public/login');//用户登录页
    Route::any('public/logout', 'admin/public/logout');//用户退出页

    /**********************后台用户管理路由*************************/
    Route::any('user/add', 'admin/user/add');//用户添加页
    Route::get('user/index', 'admin/user/index');//用户列表页
    Route::any('user/upd', 'admin/user/upd');//用户编辑页
    Route::any('user/del', 'admin/user/del');//用户删除页

    /**********************后台权限管理路由*************************/
    Route::any('auth/add', 'admin/auth/add');//权限添加页
    Route::any('auth/index', 'admin/auth/index');//权限列表页
    Route::any('auth/upd', 'admin/auth/upd');//权限编辑页
    Route::get('auth/del', 'admin/auth/del');//权限删除页

    /**********************后台角色管理路由*************************/
    Route::any('role/add', 'admin/role/add');//权限添加页

});
