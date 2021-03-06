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
Route::get('/houtai', 'admin/index/index');
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
    Route::any('role/add', 'admin/role/add');//角色分配页
    Route::get('role/index', 'admin/role/index');//角色分配列表页
    Route::any('role/upd', 'admin/role/upd');//角色分配编辑页
    Route::any('role/del', 'admin/role/del');//角色分配删除页

    /**********************后台商品类型管理路由*************************/
    Route::any('type/getattr', 'admin/type/getattr');//查看商品类型属性列表
    Route::any('type/add', 'admin/type/add');//商品类型添加页
    Route::get('type/index', 'admin/type/index');//商品类型列表页
    Route::any('type/upd', 'admin/type/upd');//商品类型编辑页
    Route::any('type/del', 'admin/type/del');//商品类型删除页

    /**********************后台商品类型属性管理路由*************************/
    Route::any('attribute/add', 'admin/attribute/add');//商品类型添加页
    Route::get('attribute/index', 'admin/attribute/index');//商品类型列表页
    Route::any('attribute/upd', 'admin/attribute/upd');//商品类型编辑页
    Route::any('attribute/del', 'admin/attribute/del');//商品类型删除页

    /**********************后台商品分类管理路由*************************/
    Route::any('category/add', 'admin/category/add');//商品分类添加页
    Route::get('category/index', 'admin/category/index');//商品分类列表页
    Route::any('category/upd', 'admin/category/upd');//商品分类编辑页
    Route::any('category/del', 'admin/category/del');//商品分类删除页

    /**********************后台商品管理路由*************************/
    Route::any('goods/add', 'admin/goods/add');//商品添加页
    Route::any('goods/getTypeAttr', 'admin/goods/getTypeAttr');//商品添加页
    Route::get('goods/index', 'admin/goods/index');//商品列表页
    Route::any('goods/upd', 'admin/goods/upd');//商品编辑页
    Route::any('goods/del', 'admin/goods/del');//商品删除页

});

//前台首页路由
Route::get('/', 'home/index/index');
//前台路由
Route::group('home', function() {
    /**********************前台登录/注册路由*************************/
    Route::any('public/register', 'home/public/register');//前台注册页面
    Route::any('public/login', 'home/public/login');//前台登录页面
    Route::get('public/logout', 'home/public/logout');//前台退出页面
    Route::get('public/SendSms', 'home/public/SendSms');//前台注册发送短信验证码页面
    Route::get('public/forgetpassword', 'home/public/forgetpassword');//前台注册发送短信验证码页面
    Route::get('public/sendemail', 'home/public/sendemail');//ajax发送邮件
    Route::any('public/setnewpassword/:member_id/:time/:hash', 'home/public/setNewPassword');//重置新密码路由

    /**********************前台导航(面包屑导航)路由*************************/
    Route::get('category/index', 'home/category/index');
    Route::get('goods/detail', 'home/goods/detail');//商品详情页
});


