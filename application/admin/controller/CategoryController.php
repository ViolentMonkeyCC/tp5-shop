<?php

namespace app\admin\controller;

use app\admin\model\Category;

class CategoryController extends CommonController
{
    //分类添加页
    public function add()
    {
        $catModel = new Category();
        //1.判断是否是post提交
        if (request()->isPost()) {
            //2.接受提交的参数
            $postData = input('post.');
            //3.验证器数据
            $result = $this->validate($postData, 'CategoryValidate.add', [], true);
            if ($result !== true) {
                //验证失败, 输出提示信息
                $this->error(implode(',', $result));
            }
            //4.判断是否入库成功
            if ($catModel->allowField(true)->save($postData)) {
                $this->success('添加成功!', url('/admin/category/index'));
            } else {
                $this->error('添加失败!');
            }
        }

        //无限极递归
        $catData = $catModel->select()->toArray();
        $cats = $catModel->getSonsCats($catData);
        return $this->fetch('', ['cats' => $cats]);
    }

    //分类列表页
    public function index(){
        //查询数据返回
        $catModel = new Category();
        $catData = $catModel->field('t1.*, t2.cat_name p_name')
            ->alias('t1')
            ->join('category t2', 't1.pid = t2.cat_id', 'left')
            ->select()
            ->toArray();
        $cats = $catModel->getSonsCats($catData);
        return $this->fetch('', ['cats' => $cats]);
    }

    //分类编辑页
    public function upd()
    {
        $catModel = new Category();
        //1.判断是否是post提交
        if (request()->isPost()) {
            //2.接收参数
            $postData = input('post.');
            //halt($postData);
            //3.验证器数据
            $result = $this->validate($postData, 'CategoryValidate.upd', [], true);
            if ($result !== true) {
                //验证失败, 输出提示信息
                $this->error(implode(',', $result));
            }

            //判断入库是否成功
            if ($catModel->allowField(true)->isUpdate(true)->save($postData)) {
                $this->success('编辑成功!', url('/admin/category/index'));
            } else {
                $this->error('编辑失败!');
            }

        }

        //回显数据
        //接收参数
        $cat_id = input('cat_id');
        $catData = $catModel->find($cat_id);
        //无限极递归
        $catDatas = $catModel->select()->toArray();
        $cats = $catModel->getSonsCats($catDatas);
        return $this->fetch('', ['catData' => $catData, 'cats' => $cats]);
    }

    //分类删除页
    public function del()
    {
        //1.接收参数
        $cat_id = input('cat_id');
        //判断是否删除成功
        if (Category::destroy($cat_id)) {
            $this->success('删除成功!', url('/admin/category/index'));
        } else {
            $this->error('删除失败!');
        }
    }
}
