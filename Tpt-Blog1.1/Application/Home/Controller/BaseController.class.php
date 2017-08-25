<?php
namespace Home\Controller;

use Think\Controller;
class BaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $navtop = D('navtop');
        $tpta = $navtop->where("tid = 0")->order('sort ASC')->select();
        $tptas = $navtop->where("tid != 0")->order('sort ASC')->select();
        $this->assign("tpta", $tpta);
        $this->assign("tptas", $tptas);
		$article = D('article');
        $commend['commend'] = 1;
		$choice['choice'] = 1;
        $open['open'] = 1;
		$tptb = $article->limit(3)->order('id DESC')->where($commend)->where($open)->select();
        $this->assign('tptb', $tptb);
        $tptc = $article->limit(5)->order('id DESC')->where($choice)->where($open)->select();
        $this->assign('tptc', $tptc);
		$links = D('links');
        $tptd = $links->select();
        $this->assign('tptd', $tptd);
		$conf = D('conf');
        $tpte = $conf->find(1);
        $this->assign("tpte", $tpte);
		$tags = C('WEB_TAG');
        $tagss = explode(',', $tags);
		$this->assign('tagss', $tagss);
    }
}