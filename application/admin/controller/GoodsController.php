<?php

namespace app\admin\controller;

use app\admin\model\Attribute;
use app\admin\model\Category;
use app\admin\model\Goods;
use app\admin\model\Type;

class GoodsController extends CommonController
{
    //商品添加页
    public function add(){
        //1.判断是否是post提交
        if (request()->isPost()) {
            //2.接受提交的参数
            $postData = input('post.');
            //3.验证器数据
            $result = $this->validate($postData, 'GoodsValidate.add', [], true);
            if ($result !== true) {
                //验证失败, 输出提示信息
                $this->error(implode(',', $result));
            }

            $goodsModel = new Goods();
            //开始上传文件
            $goods_img = $goodsModel->uploadImg();
            if ($goods_img) {   //说明原图上传成功, 进行缩略图处理
                $thumb = $goodsModel->thumb($goods_img);
                //把路径写入到数据库中(存json格式)
                $postData['goods_img'] = json_encode($goods_img);
                $postData['goods_middle'] = json_encode($thumb['goods_middle']);
                $postData['goods_thumb'] = json_encode($thumb['goods_thumb']);
            }

            //4.判断是否入库成功
            if ($goodsModel->allowField(true)->save($postData)) {
                $this->success('添加成功!', url('admin/goods/index'));
            }else {
                $this->error('添加失败!');
            }
        }

        //回显数据
        $catModel = new Category();
        $cats = $catModel->getSonsCats($catModel->select()->toArray());
        //取出商品类型
        $types = Type::select();

        return $this->fetch('', ['cats' => $cats, 'types' => $types]);
    }

    //动态生成属性列表
    public function getTypeAttr() {
        //判断是否是ajax请求
        if (request()->isAjax()) {
            //接收参数
            $type_id = input('type_id');
            //查询数据
            $attributes = Attribute::where('type_id', $type_id)->select();
            //json格式返回
            echo json_encode($attributes);die;
        }
    }
}
