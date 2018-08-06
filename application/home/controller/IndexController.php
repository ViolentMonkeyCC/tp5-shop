<?php

namespace app\home\controller;

use app\home\model\Category;
use app\home\model\Goods;
use think\Controller;

class IndexController extends Controller
{
    //前台首页
    public function index(){
        //显示导航栏
        $catModel = new Category();
        $navDatas = $catModel->getNavDate(5);

        //取出首页的三级分类筛选的数据
        $oldCat = $catModel->select()->toArray();

        //两个技巧
        //1.以每个分类的cat_id主键作为cats二维数组的主键
        $cats = [];
        foreach ($oldCat as $v) {
            $cats[$v['cat_id']] = $v;
        }
        //2.以pid进行分组
        $children = [];
        foreach ($oldCat as $v) {
            $children[$v['pid']][] = $v['cat_id'];
        }

        //取出前台推荐位的商品
        $goodsModel = new Goods();
        $crazyDatas = $goodsModel->getGoods('is_crazy', 5);
        $hotDatas = $goodsModel->getGoods('is_hot', 5);
        $bestDatas = $goodsModel->getGoods('is_best', 5);
        $newDatas = $goodsModel->getGoods('is_new', 5);
//        halt($crazyDatas->toArray());
        return $this->fetch('', [
            'navDatas' => $navDatas,
            'cats' => $cats,
            'children' => $children,
            'crazyDatas' => $crazyDatas,
            'hotDatas' => $hotDatas,
            'bestDatas' => $bestDatas,
            'newDatas' => $newDatas,
        ]);
    }
}
