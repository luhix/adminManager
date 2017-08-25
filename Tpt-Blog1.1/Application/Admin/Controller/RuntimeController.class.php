<?php
namespace Admin\Controller;

use Think\Controller;
class RuntimeController extends CommonController
{
    public function index()
    {
        $this->display();
    }
    public function doClear()
    {
        $path = "./Runtime/";
        $data = $_POST['data'];
        $count = count($data);
        for ($i = 0; $i < $count; $i++) {
            $this->dirDel($path . $data[$i] . "/");
        }
        $this->success("清除成功");
    }
    public function dirDel($path)
    {
        if (!is_dir($path)) {
            $this->error($path . "已经清理过了！");
        }
        $hand = opendir($path);
        while (($file = readdir($hand)) !== false) {
            if ($file == "." || $file == "..") {
                continue;
            }
            if (is_dir($path . "/" . $file)) {
                $this->dirDel($path . "/" . $file);
            } else {
                @unlink($path . "/" . $file);
            }
        }
        closedir($hand);
        @rmdir($path);
    }
}