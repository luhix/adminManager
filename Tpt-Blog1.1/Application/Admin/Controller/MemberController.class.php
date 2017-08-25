<?php
namespace Admin\Controller;

use Think\Controller;
class MemberController extends CommonController
{
    public function index()
    {
        $this->display();
    }
    public function doUpdate()
    {
		$pass1 = $_POST['pass1'];
        $pass2 = $_POST['pass2'];
        $kouling = $_POST['kouling'];
        if ($pass1 != $pass2 || $pass2 == '' || $pass1 == '') {
            $this->error("认真填写");
        } else {
            $data['kouling'] = $kouling;
            $data['password'] = md5($pass2);
            if ($_POST['kouling'] == '') {
                unset($data['kouling']);
            }
            $member = M("member");
            $result = $member->where("id = 1")->save($data);
            $this->myRelust($result);
        }
    }
}