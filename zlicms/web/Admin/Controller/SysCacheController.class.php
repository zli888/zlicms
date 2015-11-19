<?php
namespace Admin\Controller;
use Think\Controller;
class SysCacheController extends AdminController {
    public function index($path=''){
		if($this->unlink_dir('./web/Runtime/'))
		{
			$this->success('清除成功！');	
		}
		else
		{
			$this->error('清除失败！'); 
		}
    }
	
	function unlink_dir($path='') {		
		//先删除目录下的文件：
		$dh=opendir($path);
		while ($file=readdir($dh))
		{
			if($file!="." && $file!="..") 
			{
				$fullpath=$path."/".$file;
				if(!is_dir($fullpath)) 
				{
					unlink($fullpath);
				}
				else 
				{
					$this->unlink_dir($fullpath);
				}
			}
		}
		closedir($dh);
		//删除当前文件夹：
		if(rmdir($path)) 
		{
			return true;
		} 
		else 
		{
			return false;
		} 
	}	
}