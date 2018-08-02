<?php

namespace app\admin\controller;

use app\admin\model\Attribute;
use app\admin\model\Type;

class AttributeController extends CommonController
{
    //商品类型属性添加页
    public function add()
    {
        $attrModel = new Attribute();
        //1.判断是否是post提交
        if (request()->isPost()) {
            //2.接受提交的参数
            $postData = input('post.');
            //3.验证器数据
            if ($postData['attr_input_type'] == 1) {
                //列表选择
                $result = $this->validate($postData, 'AttributeValidate.add', [], true);
            }else {
                //手工录入
                $result = $this->validate($postData, 'AttributeValidate.except_attr_values', [], true);
            }
            if ($result !== true) {
                //验证失败, 输出提示信息
                $this->error(implode(',', $result));
            }
            //4.判断是否入库成功
            if ($attrModel->allowField(true)->save($postData)) {
                $this->success('添加成功!', url('/admin/attribute/index'));
            } else {
                $this->error('添加失败!');
            }
        }
        $types = Type::select()->toArray();
        return $this->fetch('', ['types' => $types]);
    }

    //商品类型属性列表页
    public function index(){
        $attrModel = new Attribute();
        $attrs = $attrModel->field('t1.*, t2.type_name')
            ->alias('t1')
            ->join('sh_type t2', 't1.type_id = t2.type_id', 'left')
            ->select()
            ->toArray();
        return $this->fetch('', ['attrs' => $attrs]);
    }

    //商品类型属性编辑页
    //用户编辑页
    public function upd()
    {
        $attrModel = new Attribute();
        //1.判断是否是post提交
        if (request()->isPost()) {
            //2.接收参数
            $postData = input('post.');
            //halt($postData);
            //3.验证器数据
            $result = $this->validate($postData, 'AttributeValidate.upd', [], true);
            if ($result !== true) {
                //验证失败, 输出提示信息
                $this->error(implode(',', $result));
            }

            //判断入库是否成功
            if ($attrModel->allowField(true)->isUpdate(true)->save($postData)) {
                $this->success('编辑成功!', url('/admin/attribute/index'));
            } else {
                $this->error('编辑失败!');
            }

        }

        //回显数据
        //接收参数
        $attr_id = input('attr_id');
        $attrData = $attrModel->find($attr_id);
        $types = Type::select()->toArray();
        return $this->fetch('', ['attrData' => $attrData, 'types' => $types]);
    }

    //商品类型属性删除页
    public function del()
    {
        //1.接收参数
        $attr_id = input('attr_id');
        //判断是否删除成功
        if (Attribute::destroy($attr_id)) {
            $this->success('删除成功!', url('/admin/attribute/index'));
        } else {
            $this->error('删除失败!');
        }
    }
}
