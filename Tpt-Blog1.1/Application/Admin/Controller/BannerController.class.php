<?php
namespace Admin\Controller;

use Think\Controller;
class BannerController extends CommonController
{
    public function index()
    {
        $banner = D('banner');
        $b = $banner->find(1);
        $this->assign('b', $b);
        $this->display();
    }
    public function doedit()
    {
        $banner = D('banner');
        $data = $banner->create();
        if ($_FILES['apic']['tmp_name'] != '') {
            $upload = new \Think\Upload();
            $upload->maxSize = 3145728;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
            $upload->rootPath = './Uploads/';
            $upload->savePath = '/';
            $info = $upload->uploadOne($_FILES['apic']);
            if (!$info) {
                $this->error($upload->getError());
            } else {
                $data['apic'] = $info['savepath'] . $info['savename'];
            }
        }
        if ($_FILES['bpic']['tmp_name'] != '') {
            $upload = new \Think\Upload();
            $upload->maxSize = 3145728;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
            $upload->rootPath = './Uploads/';
            $upload->savePath = '/';
            $info = $upload->uploadOne($_FILES['bpic']);
            if (!$info) {
                $this->error($upload->getError());
            } else {
                $data['bpic'] = $info['savepath'] . $info['savename'];
            }
        }
        if ($_FILES['cpic']['tmp_name'] != '') {
            $upload = new \Think\Upload();
            $upload->maxSize = 3145728;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
            $upload->rootPath = './Uploads/';
            $upload->savePath = '/';
            $info = $upload->uploadOne($_FILES['cpic']);
            if (!$info) {
                $this->error($upload->getError());
            } else {
                $data['cpic'] = $info['savepath'] . $info['savename'];
            }
        }
        $result = $banner->save($data);
        if ($result > 0) {
            $this->success('修改成功！', U('index'));
        } else {
            $this->error('修改失败！');
        }
    }
}