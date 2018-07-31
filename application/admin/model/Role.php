<?php
/**
 * Created by PhpStorm.
 * User: 城晨
 * Date: 2018/7/31
 * Time: 21:32
 */

namespace app\admin\model;

use think\Model;

class Role extends Model
{
    //主键
    protected $pk = 'role_id';
    //时间戳自动维护
    protected $autoWriteTimestamp = true;
}