<?php
namespace Admin\Controller;
use Think\Controller;
class ConTypeController extends AdminController {
    public function index(){
		$this->title="栏目列表";
		$type = M('contype')->order('id asc')->select();			
		$this->type = \Extend\Category::unlimitLevel($type,'fid','id');
		$this->display();
    }
	//操作视图
	public function save($edit=''){			
		$id = $edit ? $edit : 0 ;
		$this->title = $edit ? '编辑栏目' : '添加栏目';
		$this->v = D('contype')->find($id);	
		$this->selectType = selectOption($this->v['fid'],'contype','name','id','fid');		
		$this->display();
    }
	//添加  编辑
	public function runSave($edit=''){		
		$db = M("contype");
		$data['name'] = I('typename');
		$data['fid'] = I('fid');
		$data['seotitle'] = I('seotitle'); 
		$data['keywords'] = I('keywords');
		$data['description'] = I('description'); 
		$data['tpl_type'] = I('tpl_type'); 
		$data['tpl_list'] = I('tpl_list'); 
		$data['tpl_arc'] = I('tpl_arc');
		$data['status'] = 1;
		//编辑
		if($edit)
		{	
			$data['id']=$edit;			
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
		if(D('contype')->where(array('id' =>array( 'in', $id)))->delete())
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
		if(M('contype')->where('id in ('.$id.')')->save($data))
		{
			$this->success('操作成功！');
		}	
		else
		{
			$this->error('操作失败！');
		}	
	}				
}