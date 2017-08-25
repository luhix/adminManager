<?php
namespace Admin\Controller;

use Think\Controller;
class CategoryController extends CommonController
{
    public function index()
    {
        $category = D('category');
        $c = $category->where("tid = 0")->order('id ASC')->select();
        $cs = $category->where("tid != 0")->order('id ASC')->select();
        $this->assign("c", $c);
        $this->assign("cs", $cs);
        $this->display();
    }
    public function add()
    {
        $category = D('category');
        $c = $category->where("tid=0")->select();
        $this->assign("c", $c);
        $this->display();
    }
    public function doadd()
    {
        $category = D('category');
        $data = $category->create();
        $data['time'] = time();
        if ($_FILES['pic']['tmp_name'] != '') {
            $upload = new \Think\Upload();
            $upload->maxSize = 3145728;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
            $upload->rootPath = './Uploads/';
            $upload->savePath = '/';
            $info = $upload->uploadOne($_FILES['pic']);
            if (!$info) {
                $this->error($upload->getError());
            } else {
                $data['pic'] = $info['savepath'] . $info['savename'];
            }
        }
        $result = $category->add($data);
        if ($result > 0) {
            $this->success('添加成功！', U('index'));
        } else {
            $this->error('添加失败！');
        }
    }
    public function edit($id)
    {
        $category = D('category');
        $c = $category->find($id);
        $this->assign('c', $c);
        $cs = $category->where("tid = 0")->select();
        $this->assign('cs', $cs);
        $this->display();
    }
    public function doedit()
    {
        $category = D('category');
        $data = $category->create();
        if ($_FILES['pic']['tmp_name'] != '') {
            $upload = new \Think\Upload();
            $upload->maxSize = 3145728;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
            $upload->rootPath = './Uploads/';
            $upload->savePath = '/';
            $info = $upload->uploadOne($_FILES['pic']);
            if (!$info) {
                $this->error($upload->getError());
            } else {
                $data['pic'] = $info['savepath'] . $info['savename'];
            }
        }
        $result = $category->save($data);
        if ($result > 0) {
            $this->success('修改成功！', U('index'));
        } else {
            $this->error('修改失败！');
        }
    }
    public function delete($id)
    {
        $category = D("category");
        $check = $category->where("tid={$id}")->find();
        if ($check != null) {
            $this->error("请先删除子栏目");
        } else {
            $result = $category->delete($id);
        }
        if ($result > 0) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
}