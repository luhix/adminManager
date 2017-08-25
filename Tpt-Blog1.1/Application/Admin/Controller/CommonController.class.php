<?php
namespace Admin\Controller;

use Think\Controller;
class CommonController extends Controller
{
    function _initialize()
    {
        $member = D('member');
        $arr = $member->where("username = '%s'", $_SESSION['username'])->find();
        if ($_SESSION['username'] == "" || $arr == null || $_SESSION['kouling'] != md5(md5($arr['kouling']))) {
            $this->error('请登录！', U('Login/index'), 3);
        }
    }
    public function myRelust($result)
    {
        if ($result == false) {
            $this->error("操作失败！");
        } else {
            $this->success("操作成功！");
        }
    }
}