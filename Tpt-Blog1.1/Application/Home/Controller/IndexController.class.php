<?php
namespace Home\Controller;

use Think\Controller;
class IndexController extends BaseController
{
    public function index()
    {
        $banner = D('banner');
        $tptf = $banner->find(1);
        $this->assign('tptf', $tptf);
        $article = D('ArticleView');
        $open['open'] = 1;
        $count = $article->count();
        $Page = new \Think\Page($count, 15);
        $show = $Page->show();
        $tptg = $article->where($open)->order('id DESC')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('tptg', $tptg);
        $this->assign('page', $show);
        $this->display();
    }
    public function search()
    {
        $article = D('ArticleView');
        $where = 1;
        if ($kw = I('kw')) {
            $where .= ' AND title LIKE "%' . $kw . '%"';
        }
        $count = $article->count();
        $Page = new \Think\Page($count, 15);
        $show = $Page->show();
        $tpth = $article->where($where)->order('id DESC')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('tpth', $tpth);
        $this->assign('page', $show);
        $this->display();
    }
	public function tags()
    {
        $article = D('ArticleView');
        $where = 1;
        if ($ks = I('ks')) {
            $where .= ' AND article.keywords LIKE "%' . $ks . '%"';
        }
        $count = $article->count();
        $Page = new \Think\Page($count, 15);
        $show = $Page->show();
        $tpth = $article->where($where)->order('id DESC')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('tpth', $tpth);
        $this->assign('page', $show);
        $this->display();
    }
    public function category()
    {
        $article = D('article');
        $open['open'] = 1;
        $id = I('id');
        $category = D('category');
        $c = $category->where("id = {$id}")->find();
        if ($c) {
            $tpti = $category->where("id ={$id}")->find();
            $this->assign("tpti", $tpti);
            $count = $article->where("tid={$id}")->count();
            $Page = new \Think\Page($count, 15);
            $show = $Page->show();
            $tptj = $article->where("tid={$id}")->where($open)->order('id DESC')->limit($Page->firstRow . ',' . $Page->listRows)->select();
            $this->assign('tptj', $tptj);
            $this->assign('page', $show);
            $this->display();
        } else {
            $this->error("亲！你迷路了！");
        }
    }
    public function article()
    {
        $article = D('article');
        $open['open'] = 1;
        $id = I('id');
        $a = $article->where("id = {$id}")->where($open)->find();
        if ($a) {
            $article->where("id = {$id}")->setInc('view', 1);
            $tptl = $article->find($id);
            $this->assign('tptl', $tptl);
            $content = $tptl['content'];
            $content = htmlspecialchars_decode($content);
            $this->assign('content', $content);
            $category = D('category');
            $tpti = $category->where("id = {$tptl['tid']}")->find();
            $this->assign("tpti", $tpti);
            $this->display();
        } else {
            $this->error("文章已被删除或正在审核！");
        }
    }
    public function tougao()
    {
        $conf = D('conf');
        $open['open'] = 1;
        $c = $conf->where($open)->find();
        if ($c) {
            $this->display();
        } else {
            $this->error("亲！你迷路了！", U('index'));
        }
    }
    public function doUploadPic()
    {
        $upload = new \Think\Upload();
        $upload->maxSize = 3145728;
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
        $upload->rootPath = './Uploads/';
        $upload->savePath = '/';
        $info = $upload->upload();
        if(!$info){
            $this->error($upload->getError());
        }else{
            foreach($info as $file){
		    $data = '/Uploads'.$file['savepath'] . $file['savename'];
			$this->ajaxReturn($data,'EVAL');
			}
        }
    }
    public function geetest_show_verify()
    {
        $geetest_id = C('GEETEST_ID');
        $geetest_key = C('GEETEST_KEY');
        $geetest = new \Org\Xb\Geetest($geetest_id, $geetest_key);
        $user_id = "test";
        $status = $geetest->pre_process($user_id);
        $_SESSION['geetest'] = array('gtserver' => $status, 'user_id' => $user_id);
        echo $geetest->get_response_str();
    }
    public function geetest_submit_check()
    {
        $data = I('post.');
        if (geetest_chcek_verify($data)) {
            $article = D('article');
            if (IS_POST) {
                $data['title'] = I('title');
                $data['author'] = I('author');
                $data['content'] = I('content');
                $data['time'] = time();
                $data['open'] = 0;
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
                if ($article->create($data)) {
                    if ($article->add()) {
                        $this->success('投稿成功！', U('index'));
                    } else {
                        $this->error('投稿失败！');
                    }
                } else {
                    $this->error($article->getError());
                }
                return;
            }
        } else {
            $this->error('请输入验证码！');
        }
    }
}