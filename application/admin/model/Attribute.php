<?php

namespace app\admin\model;

use think\Model;

class Attribute extends Model
{
    //主键
    protected $pk = 'attr_id';
    //时间戳自动维护
    protected $autoWriteTimestamp = true;
}
