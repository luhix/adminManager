<?php
namespace Admin\Controller;

use Think\Controller;
class LinksController extends CommonController
{
    public function index()
    {
        $links = D('links');
        $count = $links->where($where)->count();
        $Page = new \Think\Page($count, 15);
        $show = $Page->show();
        $list = $links->where($where)->order('id DESC')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }
    public function add()
    {
        $links = D('links');
        $this->display();
    }
    public function doadd()
    {
        $links = D('links');
        $data = $links->create();
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
        $result = $links->add($data);
        if ($result > 0) {
            $this->success('添加成功！', U('index'));
        } else {
            $this->error('添加失败！');
        }
    }
    public function edit($id)
    {
        $links = D('links');
        $l = $links->find($id);
        $this->assign('l', $l);
        $this->display();
    }
    public function doedit()
    {
        $links = D('links');
        $data = $links->create();
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
        $result = $links->save($data);
        if ($result > 0) {
            $this->success('修改成功！', U('index'));
        } else {
            $this->error('修改失败！');
        }
    }
    public function delete($id)
    {
        $links = D('links');
        if ($links->delete($id)) {
            $this->success('删除成功!', U('index'));
        } else {
            $this->error('删除失败！');
        }
    }
}