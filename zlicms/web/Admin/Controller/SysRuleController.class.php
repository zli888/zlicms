<?php
namespace Admin\Controller;
use Think\Controller;
class SysRuleController extends AdminController {  
	//列表
    public function index(){
		$this->title = "操作列表";
		$type = M('admin_rule')->order('sort asc')->select();
		$types = new \Extend\Category();        
		$this->rule_list = $types->unlimitLevel($type,'fid','id');
		$this->display();
    }
	//视图
	public function Save($edit=''){		
		$id = $edit ? $edit : 0 ;
		$this->title = $id ? '编辑操作' : '添加操作';
		$this->v = M('admin_rule')->find($id);
		$this->select_rule = select_rule($this->v['fid']);		
		$this->display();
    }
	//添加  编辑
	public function RunSave($edit=''){		
		$db = M('admin_rule');
		$data['title'] = I('title');
		$data['name'] = I('name');
		$data['sort'] = I('sort');
		$data['fid'] = I('fid');
		//编辑
		if($edit)
		{	
			$data['id']=I('get.edit');			
			if($db->save($data))
			{
				$this->success('编辑成功！',U('index'));
			}
			else
			{
				$this->error('编辑失败！');
			} 
		}		
		//添加
		else
		{			
			if($db->add($data))
			{
				$this->success('添加成功！',U('index'));
			}
			else
			{
				$this->error('添加失败！');
			} 			
		}
    }
	//删除
	public function del($id=''){	
		if(M('admin_rule')->where(array('id' =>array( 'in', $id)))->delete())
		{
			$this->success('删除成功！');
		}	
		else
		{
			$this->error('删除失败！');
		}	
    }
	//启用 禁用
	public function job($job="",$id=""){	
		$data['status'] = $job=='pass' ? 1 : 0;
		if(M('admin_rule')->where('id in ('.$id.')')->save($data))
		{
			$this->success('操作成功！');
		}	
		else
		{
			$this->error('操作失败！');
		}	
	}			
}