<?php

namespace app\admin\model;

use think\Model;

class Type extends Model
{
    //主键
    protected $pk = 'type_id';
    //时间戳自动维护
    protected $autoWriteTimestamp = true;
}
