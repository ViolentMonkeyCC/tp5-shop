<?php

namespace app\admin\controller;

use app\admin\model\Attribute;
use app\admin\model\Type;

class TypeController extends CommonController
{
    //商品类型添加页
    public function add()
    {
        $typeModel = new Type();
        //1.判断是否是post提交
        if (request()->isPost()) {
            //2.接受提交的参数
            $postData = input('post.');
            //3.验证器数据
            $result = $this->validate($postData, 'TypeValidate.add', [], true);
            if ($result !== true) {
                //验证失败, 输出提示信息
                $this->error(implode(',', $result));
            }
            //4.判断是否入库成功
            if ($typeModel->allowField(true)->save($postData)) {
                $this->success('添加成功!', url('/admin/type/index'));
            } else {
                $this->error('添加失败!');
            }
        }
        return $this->fetch();
    }

    //商品类型列表页
    public function index(){
        //回显数据
        $types = Type::select()->toArray();
        return $this->fetch('', ['types' => $types]);
    }
    
    //商品类型编辑页
    public function upd()
    {
        $typeModel = new Type();
        //1.判断是否是post提交
        if (request()->isPost()) {
            //2.接收参数
            $postData = input('post.');
            //halt($postData);
            //3.验证器数据
            $result = $this->validate($postData, 'TypeValidate.upd', [], true);
            if ($result !== true) {
                //验证失败, 输出提示信息
                $this->error(implode(',', $result));
            }

            //判断入库是否成功
            if ($typeModel->allowField(true)->isUpdate(true)->save($postData)) {
                $this->success('编辑成功!', url('/admin/type/index'));
            } else {
                $this->error('编辑失败!');
            }

        }

        //回显数据
        //接收参数
        $type_id = input('type_id');
        $typeData = $typeModel->find($type_id);
        return $this->fetch('', ['typeData' => $typeData]);
    }

    //商品类型删除页
    public function del()
    {
        //1.接收参数
        $type_id = input('type_id');
        //判断是否删除成功
        if (Type::destroy($type_id)) {
            $this->success('删除成功!', url('/admin/type/index'));
        } else {
            $this->error('删除失败!');
        }
    }

    //查看商品类型属性列表
    public function getattr(){
        //接收参数
        $type_id = input('type_id');
        //获取type_name的字段值
        $type_name = Type::where('type_id', $type_id)->value('type_name');
        $attributes = Attribute::where('type_id', $type_id)->select();
        return $this->fetch('', ['type_name' => $type_name, 'attributes' => $attributes]);
    }
}
