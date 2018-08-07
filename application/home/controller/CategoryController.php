<?php

namespace app\home\controller;

use app\home\model\Category;
use think\Controller;

class CategoryController extends Controller
{
    //
    public function index(){
        $cat_id = input('cat_id');
        //获取当前分类id祖先分类(面包屑导航)
        $catModel = new Category();
        //获取祖先分类
        $cats = $catModel->select()->toArray();
        $familysCat = $catModel->getfamilysCat($cats, $cat_id);

    }
}
