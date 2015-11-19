<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends AdminController {
    public function index(){
		$this->title="首页管理";
		$this->display();
    }
}