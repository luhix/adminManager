<?php
function geetest_chcek_verify($data){
    $geetest_id=C('GEETEST_ID');
    $geetest_key=C('GEETEST_KEY');
    $geetest=new \Org\Xb\Geetest($geetest_id,$geetest_key);
    $user_id=$_SESSION['geetest']['user_id'];
    if ($_SESSION['geetest']['gtserver']==1) {
        $result=$geetest->success_validate($data['geetest_challenge'], $data['geetest_validate'], $data['geetest_seccode'], $user_id);
        if ($result) {
            return true;
        } else{
            return false;
        }
    }else{
        if ($geetest->fail_validate($data['geetest_challenge'],$data['geetest_validate'],$data['geetest_seccode'])) {
            return true;
        }else{
            return false;
        }
    }
}