<?php
namespace Admin\Controller;

use Think\Controller;
class NavtopController extends CommonController
{
    public function index()
    {
        $navtop = D('navtop');
        $n = $navtop->where("tid = 0")->order('sort ASC')->select();
        $ns = $navtop->where("tid != 0")->order('sort ASC')->select();
        $this->assign("n", $n);
        $this->assign("ns", $ns);
        $this->display();
    }
    public function add()
    {
        $navtop = D('navtop');
        $n = $navtop->where("tid=0")->select();
        $this->assign("n", $n);
        $this->display();
    }
    public function doadd()
    {
        $navtop = D('navtop');
        $data = $navtop->create();
        $data['time'] = time();
        $result = $navtop->add($data);
        if ($result > 0) {
            $this->success('添加成功！', U('index'));
        } else {
            $this->error('添加失败！');
        }
    }
    public function edit($id)
    {
        $navtop = D('navtop');
        $n = $navtop->find($id);
        $this->assign('n', $n);
        $ns = $navtop->where("tid = 0")->select();
        $this->assign('ns', $ns);
        $this->display();
    }
    public function doedit()
    {
        $navtop = D('navtop');
        $data = $navtop->create();
		$data['blank'] = I('blank');
        $result = $navtop->save($data);
        if ($result > 0) {
            $this->success('修改成功！', U('index'));
        } else {
            $this->error('修改失败！');
        }
    }
    public function delete($id)
    {
        $navtop = D("navtop");
        $check = $navtop->where("tid={$id}")->find();
        if ($check != null) {
            $this->error("请先删除子导航");
        } else {
            $result = $navtop->delete($id);
        }
        if ($result > 0) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
}