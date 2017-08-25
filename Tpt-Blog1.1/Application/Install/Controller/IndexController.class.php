<?php
namespace Install\Controller;

use Think\Controller;
use Think\Storage;
class IndexController extends Controller
{
    public function index()
    {
        if (Storage::has(MODULE_PATH . 'Data/install.lock')) {
            $this->error('您已经安装成功了!');
        }
        session_destroy();
        session_start();
        session('step', 0);
        session('error', false);
        $this->display();
    }
    public function complete()
    {
        $step = session('step');
        if (!$step) {
            $this->redirect('index');
        } elseif ($step != 3) {
            $this->redirect("Install/step{$step}");
        }
        Storage::put(MODULE_PATH . 'Data/install.lock', 'lock');
        $this->assign('info', session('config_file'));
        session('step', null);
        session('error', null);
        $this->display();
    }
}