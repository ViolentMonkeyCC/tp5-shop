<?php

namespace app\home\controller;

use app\home\model\Category;
use app\home\model\Goods;
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

        //两个技巧
        //1.以每个cat_id作为二维数组的下标
        $catsData = [];
        foreach ($cats as $v) {
            $catsData[$v['cat_id']] = $v;
        }
        //2.以pid进行分组
        $children = [];
        foreach ($cats as $vv) {
            $children[$vv['pid']][] = $vv['cat_id'];
        }

        //获取当前分类下的所有子孙分类
        $sonsCatId = $catModel -> getSonsCatId($cats, $cat_id);
        //当前分类也需要加上
        $sonsCatId[] = (int)$cat_id;
        //通过获取的分类id把分类名称查出来
        $where = [
            'is_sale' => 1,
            'is_delete' => 0,
            'cat_id' => ['in', $sonsCatId],
        ];
        $goodsDatas = Goods::where($where)->select()->toArray();
        //halt($goodsDatas);

        return $this->fetch('', [
            'familysCat' => $familysCat,
            'catsData' => $catsData,
            'children' => $children,
            'goodsDatas' => $goodsDatas,
        ]);
    }
}
