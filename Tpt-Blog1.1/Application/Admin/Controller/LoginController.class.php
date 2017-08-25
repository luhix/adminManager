<?php
namespace Admin\Controller;

use Think\Controller;
class LoginController extends Controller
{
    public function index()
    {
        $this->display();
    }
    public function checklogin()
    {
        $username = I('post.username');
        $password = md5(I('post.password'));
        $kouling = I('post.kouling');
        $member = D('member');
        $result = $member->where("username='%s' AND password='%s' AND kouling='%s'", $username, $password, $kouling)->find();
        if ($result) {
            $_SESSION['username'] = $result['username'];
            $_SESSION['kouling'] = md5(md5($result['kouling']));
            $this->success('登陆成功', U('Index/index'), 3);
        } else {
            $this->error('登陆失败');
        }
    }
    public function logout()
    {
        session(null);
        $this->success('欢迎再来', U('/'), 3);
    }
}