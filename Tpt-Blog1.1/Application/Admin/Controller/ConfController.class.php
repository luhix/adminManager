<?php
namespace Admin\Controller;

use Think\Controller;
class ConfController extends CommonController
{
    public function index()
    {
        $conf = D('conf');
        $c = $conf->find(1);
        $this->assign("c", $c);
        $this->display();
    }
    public function doedit()
    {
        $conf = D('conf');
        $data = $conf->create();
        $data['open'] = I('open');
		if ($_FILES['logo']['tmp_name'] != '') {
            $upload = new \Think\Upload();
            $upload->maxSize = 3145728;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
            $upload->rootPath = './Uploads/';
            $upload->savePath = '/';
            $info = $upload->uploadOne($_FILES['logo']);
            if (!$info) {
                $this->error($upload->getError());
            } else {
                $data['logo'] = $info['savepath'] . $info['savename'];
            }
        }
        $result = $conf->save($data);
        if ($result > 0) {
            $this->success('修改成功！', U('index'));
        } else {
            $this->error('修改失败！');
        }
    }
	public function webconf(){
        
       $path = 'Application/Common/Conf/webconf.php';
       $file = include $path;      
       $config = array(
           'WEB_URL' => I('WEB_URL'),
		   'WEB_TPT' => I('WEB_TPT'),
		   'GEETEST_ID' => I('GEETEST_ID'),
		   'GEETEST_KEY' => I('GEETEST_KEY'),
		   'WEB_TAG' => I('WEB_TAG'),
		   'WEB_CID' => I('WEB_CID'),
		   'WEB_CKEY' => I('WEB_CKEY'),
       );
       $res = array_merge($file, $config);
       $str = '<?php return array(';
        
       foreach ($res as $key => $value){
           $str .= '\''.$key.'\''.'=>'.'\''.$value.'\''.',';
       };
       $str .= '); ?>';
       if(file_put_contents($path, $str)){
           $this->success('修改成功！', U('index'));
       }else {
           $this->error('修改失败！');
       }
        
    }
}