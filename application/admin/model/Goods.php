<?php

namespace app\admin\model;

use think\Db;
use think\Model;

class Goods extends Model
{
    //主键
    protected $pk = 'goods_id';
    //时间戳自动维护
    protected $autoWriteTimestamp = true;

    //多文件上传方法
    public function uploadImg() {
        $goods_img = [];//用于存储文件的上传路径
        //接收上传文件的name名称
        $files = request()->file('img');
        if ($files) {
            //文件上传的要求
            $validate = [
                'size' => 3*1024*1024,
                'ext' => 'jpg,png,gif,jpeg',
            ];
            //上传的目录
            $uploadDir = './static/upload';
            //开始上传文件, 多文件上传需要循环上传
            foreach ($files as $file) {
                $info = $file->validate($validate)->move($uploadDir);
                if ($info) {
                    //存储文件的路径到数组中去,把反斜杠替换成正斜杠
                    $goods_img[] = str_replace('\\', '/', $info->getSaveName());
                }
            }
        }
        return $goods_img;
    }

    //多文件的缩略图处理
    public function thumb($goods_img) {
        $goods_middle = [];
        $goods_thumb = [];
        //350*350
        foreach ($goods_img as $path) {
            $arr_path = explode('/', $path);
            $middle_path = $arr_path[0].'/middle_'.$arr_path[1];
            //打开原图的路径
            $image = \think\Image::open("./static/upload/".$path);
            //2 填充补白
            $image->thumb(350, 350, 2)->save("./static/upload/".$middle_path);
            //存储图片路径
            $goods_middle[] = $middle_path;
        }

        //50*50
        foreach ($goods_img as $path) {
            $arr_path = explode('/', $path);
            $thumb_path = $arr_path[0].'/thumb_'.$arr_path[1];
            //打开原图的路径
            $image = \think\Image::open("./static/upload/".$path);
            //2 填充补白
            $image->thumb(50, 50, 2)->save("./static/upload/".$thumb_path);
            //存储图片路径
            $goods_thumb[] = $thumb_path;
        }
        //返回路径
        return ['goods_middle' => $goods_middle, 'goods_thumb' => $goods_thumb];
    }

    //事件处理
    protected static function init() {
        Goods::event('before_insert', function ($goods) {
            //设置货号唯一
            $goods['goods_sn'] = date('ymdhis').mt_rand();
        });

        //入库后的事件after_insert,完成商品的入库到商品属性表(sh_goods_attr)
        Goods::event('after_insert', function($goods) {
            //$goods 当表单对象数据入库成功之后,返回表的记录数据对象,其中带着自增主键goods_id
            $goods_id = $goods['goods_id'];
            $postData = input('post.');
            $goodsAttrValue = $postData['goodsAttrValue'];
            $goodsAttrPrice = $postData['goodsAttrPrice'];
            //因为有多个属性,所以需要循环进行入库(sh_goods_attr)
            foreach ($goodsAttrValue as $attr_id=>$attr_value) {
                //单选属性$attr_value是一个数组
                if (is_array($attr_value)) {
                    foreach ($attr_value as $k => $singel_attr_value) {
                        $data = [
                            'goods_id' => $goods_id,
                            'attr_id' => $attr_id,
                            'attr_value' => $singel_attr_value,
                            //通过下标获取单选属性对应的价格
                            'attr_price' => $goodsAttrPrice[$attr_id][$k],
                            'create_time' => time(),
                            'update_time' => time(),
                        ];
                        //入库到商品属性表
                        Db::name('goods_attr')->insert($data);
                    }
                }else {
                    $data = [
                        'goods_id' => $goods_id,
                        'attr_id' => $attr_id,
                        'attr_value' => $attr_value,
                        'create_time' => time(),
                        'update_time' => time(),
                    ];
                    //入库到商品属性表
                    Db::name('goods_attr')->insert($data);
                }
            }
        });
    }
}
