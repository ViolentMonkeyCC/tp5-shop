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
}
