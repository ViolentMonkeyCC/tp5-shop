<?php
/**
 * Created by PhpStorm.
 * User: 城晨
 * Date: 2018/7/31
 * Time: 19:00
 */

namespace app\admin\model;

use think\Model;

class Auth extends Model
{
    //主键
    protected $pk = 'auth_id';
    //时间戳自动维护
    protected $autoWriteTimestamp = true;

    //处理无限极递归数据
    public function getSonsCats($data, $pid = 0, $level = 1){
        //取出数据,进行处理
        static $result = [];    //静态变量,只初始化一次
        foreach ($data as $v) {
            if ($v['pid'] == $pid) {
                $v['level'] = $level;//加一个层级
                $result[] = $v; //存放在result中
                //递归调用查找子孙
                $this->getSonsCats($data, $v['auth_id'], $level+1);
            }
        }
        return $result;
    }

    //事件处理
    protected static function init() {
        Auth::event('before_update', function ($auth){
             if ($auth['pid'] == 0) {
                 $auth['auth_a'] = '';
                 $auth['auth_c'] = '';
             }
        });
    }
}