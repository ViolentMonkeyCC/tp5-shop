<?php

namespace app\home\model;

use think\Model;

class Goods extends Model
{
    //主键
    protected $pk = 'goods_id';

    public function getGoods($type, $limit){
        //定义初始的查询条件
        $where = [
            'is_sale' => 1,
        ];
        switch ($type){
            case 'is_crazy':
                //按照价格升序取出来
                $data = $this->where($where)->order('goods_price asc')->limit($limit)->select();
                break;
            default :
                $where[$type] = ['=', 1];
                $data = $this->where($where)->limit($limit)->select();
        }
        //返回商品数据
        return $data;
    }

    //商品加入浏览历史cookie中
    public function addGoodsToHistory($goods_id) {
        //由于加入商品goods_id之前,cookie可能已经有数据了,要先判断下取出来
        $history = cookie('history')?cookie('history'):[];
        if ($history) {
            //说明浏览历史中有数据
            //1.把商品id加入$history头部
            array_unshift($history, $goods_id);
            //2.$history去除重复的商品
            $history = array_unique($history);
            //3.判断$history是否超过指定的长度
            if (count($history) > 5) {
                //移除数组的最后一个数据
                array_pop($history);
            }
        }else {
            //说明浏览历史中没有数据
            $history[] = $goods_id;
        }
        //把浏览数据写入到cookie中,cookie只能存储字符串,不能存储数组,一般存之前需要序列化(serialize),取出来需要进行反序列化(unserialize)
        //tp5框架已经集成了这些
        cookie('history', $history, 3600*24*7);//有效时间7天
        //返回数据
        return $history;
    }
}
