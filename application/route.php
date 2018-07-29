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

    /**********************后台用户管理路由*************************/
    Route::any('user/add', 'admin/user/add');//用户添加页
    Route::get('user/index', 'admin/user/index');//用户列表页
    Route::any('user/upd', 'admin/user/upd');//用户编辑页
    Route::any('user/del', 'admin/user/del');//用户删除页


});
