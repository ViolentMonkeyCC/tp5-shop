<?php

namespace app\admin\model;

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
}
