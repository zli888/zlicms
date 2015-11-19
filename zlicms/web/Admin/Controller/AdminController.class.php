<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 后台公共控制器
 */
class AdminController extends Controller {
    protected function _initialize(){
     	// 获取当前用户ID 
        $admin = session('admin');        
		if ( $admin == false ) {
			session('admin', null);
        	session('[destroy]');
			$this->error ( '您尚未登录！正在跳转登录页面', U ( 'Login/login' ) );
		}		
		//菜单
		//$this->menu = M('admin_rule')->where(array('fid'=>0,'status'=>1))->order('sort asc')->cache('menu')->select();
		$menu = M('admin_rule')->where(array('status'=>1))->order('sort asc')->cache('menu')->select();
		$menus = new \Extend\Category();        
		$this->menu = $menus->unlimitLayer($menu,'fid','id');
		//p($this->menu);		  		
    }
}  