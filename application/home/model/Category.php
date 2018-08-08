<?php

namespace app\home\model;

use think\Model;

class Category extends Model
{
    //主键
    protected $pk = 'cat_id';

    //获取导航栏的分类数据
    public function getNavDate($limit){
        return $this->where('is_show', '1')->limit($limit)->select();
    }
    
    //找祖先分类
    public function getfamilysCat($data, $cat_id){
        static $result = [];
        foreach ($data as $k => $v) {
            //第一次循环,找到自己
            if($v['cat_id'] == $cat_id) {
                $result[] = $v;
                //删除已经判断过的分类
                unset($data[$k]);
                //递归调用
                $this->getfamilysCat($data, $v['pid']);
            }
        }
        //返回结果并把数组反转
        return array_reverse($result);
    }

    //找子孙分类id
    public function getSonsCatId($cats, $cat_id) {
        static $cats_id= [];
        foreach ($cats as $k => $v) {
            if ($cat_id == $v['pid']) {
                $cats_id[] = $v['cat_id'];
                //删除已经判断过的分类
                unset($cats[$k]);
                //递归调用
                $this->getSonsCatId($cats, $v['cat_id']);
            }
        }
        //返回数据
        return $cats_id;
    }
}
