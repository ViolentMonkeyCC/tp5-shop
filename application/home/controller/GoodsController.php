<?php

namespace app\home\controller;

use app\home\model\Category;
use app\home\model\Goods;
use think\Controller;
use think\Db;

class GoodsController extends Controller
{
    //商品详情页
    public function detail($goods_id = 0){
        //接收参数(参数也可通过依赖注入来获取)
        //$goods_id = input('goods_id');
        $goodsInfo = Goods::find($goods_id)->toArray();
        //halt($goodsInfo);
        //面包屑导航
        $catModel = new Category();
        $cats = $catModel->select();
        $familysData = $catModel->getfamilysCat($cats, $goodsInfo['cat_id']);
        $goodsInfo['goods_img'] = json_decode($goodsInfo['goods_img']);
        $goodsInfo['goods_middle'] = json_decode($goodsInfo['goods_middle']);
        $goodsInfo['goods_thumb'] = json_decode($goodsInfo['goods_thumb']);
        //halt($goodsInfo['goods_thumb']);
        //halt($goodsInfo);

        //取出商品的单选属性数据
        $_singelAttrDatas = Db::name('goods_attr')
            ->field('t1.*, t2.attr_name')
            ->alias('t1')
            ->join('sh_attribute t2', 't1.attr_id = t2.attr_id', 'left')
            ->where('t1.goods_id =' . $goods_id . ' and t2.attr_type=1')
            ->select();
        //通过attr_id把单选属性进行分组,为了后续在模板中遍历
        $singelAttrDatas = [];
        foreach ($_singelAttrDatas as $v) {
            $singelAttrDatas[$v['attr_id']][] = $v;
        }
        //halt($singelAttrDatas);

        //取出商品的唯一属性
        $onlyAttrDatas = Db::name('goods_attr')
            ->field('t1.*, t2.attr_name')
            ->alias('t1')
            ->join('sh_attribute t2', 't1.attr_id = t2.attr_id', 'left')
            ->where('t1.goods_id = '. $goods_id .' and t2.attr_type = 0')
            ->select();
        //halt($onlyAttrDatas);

        //把访问过的商品goods_id加入到浏览器历史cookie中
        $goodsModel = new Goods();
        $history = $goodsModel->addGoodsToHistory($goods_id);//[1,2]
        //取出浏览历史中的商品信息
        $where = [
            'is_delete' => 0,
            'is_sale' => 1,
            'goods_id' => ['in', $history],
        ];
        //数组变为字符串
        $goods_str_ids = implode(',', $history);
        $historyDatas = Goods::where($where)->orderRaw("field(goods_id,$goods_str_ids)")/*->fetchSql(true)*/->select()->toArray();
        //halt($historyDatas);

        return $this->fetch('', [
            'familysData' => $familysData,
            'goodsInfo' => $goodsInfo,
            'singelAttrDatas' => $singelAttrDatas,
            'onlyAttrDatas' => $onlyAttrDatas,
            'historyDatas' => $historyDatas,
        ]);
    }
}
