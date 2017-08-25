<?php
namespace Install\Controller;

use Think\Controller;
use Think\Db;
use Think\Storage;
class InstallController extends Controller
{
    protected function _initialize()
    {
        if (session('step') === null) {
            $this->redirect('Index/index');
        }
        if (Storage::has(MODULE_PATH . 'Data/install.lock')) {
            $this->error('您已经安装成功了!');
        }
    }
    //安装第一步，检测运行所需的环境设置
    public function step1()
    {
        session('error', false);
        //环境检测
        $env = check_env();
        //目录文件读写检测
        if (IS_WRITE) {
            $dirfile = check_dirfile();
            $this->assign('dirfile', $dirfile);
        }
        //函数检测
        $func = check_func();
        session('step', 1);
        $this->assign('env', $env);
        $this->assign('func', $func);
        $this->display();
    }
    //安装第二步，创建数据库
    public function step2($db = null)
    {
        if (IS_POST) {
            //检测数据库配置
            if (!is_array($db) || empty($db[0]) || empty($db[1]) || empty($db[2]) || empty($db[3])) {
                $this->error('请填写完整的数据库配置!');
            } else {
                $DB = array();
                list($DB['DB_TYPE'], $DB['DB_HOST'], $DB['DB_NAME'], $DB['DB_USER'], $DB['DB_PWD'], $DB['DB_PORT'], $DB['DB_PREFIX']) = $db;
                //缓存数据库配置
                session('db_config', $DB);
                //创建数据库
                $dbname = $DB['DB_NAME'];
                unset($DB['DB_NAME']);
                $db = Db::getInstance($DB);
                $sql = "CREATE DATABASE IF NOT EXISTS `{$dbname}` DEFAULT CHARACTER SET utf8";
                $db->execute($sql) || $this->error($db->getError());
            }
            //跳转到数据库安装页面
            $this->redirect('step3');
        } else {
            session('error') && $this->error('请调整环境后重试！');
            $step = session('step');
            if ($step != 1 && $step != 2) {
                $this->redirect('step1');
            }
            session('step', 2);
            $this->display();
        }
    }
    //安装第三步，安装数据表，创建配置文件
    public function step3()
    {
        if (session('step') != 2) {
            $this->redirect('step2');
        }
        $this->display();
        //连接数据库
        $dbconfig = session('db_config');
        $db = Db::getInstance($dbconfig);
        //创建数据表
        create_tables($db, $dbconfig['DB_PREFIX']);
        //创建配置文件
        $conf = write_config($dbconfig);
        session('config_file', $conf);
        if (session('error')) {
            //show_msg();
        } else {
            session('step', 3);
            $this->redirect('Index/complete');
        }
    }
}