<?php
namespace Admin\Controller;
use Think\Controller;
class ConArcController extends AdminController {
    //列表
    public function index(){ 
		$this->title = "文档列表";
		$where = " tpl = '' ";				
		$where .= I('id',0) ? ' and conarc.id = '.I('id') : '';
		$where .= I('keyword',0) ? " and title like '%".I('keyword')."%'" : "";
		$where .= I('fid',0) ? ' and conarc.fid in ('.getSons(I('fid')).') ' : '';
		$where .= I('flag',0) ? ' and FIND_IN_SET('.I('flag').',flag)' : '';		
		$where .= I('begin',0) ? " and pubdate >= ".strtotime(I('begin')) : "";
		$where .= I('end',0) ? " and pubdate <= ".(strtotime(I('end'))+86399) : "";	
		
		$count = D('ConarcView')->where($where)->count();
		$page = new \Think\Page($count,10);
		$limit = $page->firstRow.','.$page->listRows;		
		$this->arc = D('ConarcView')->where($where)->order('id desc')->limit($limit)->select();
		$this->page =$page->show();
		$this->selectType = selectType();
		$this->display();
    }
	//操作视图
	public function save($edit=''){			
		$id = $edit ? $edit : 0 ;
		$this->title = $id ? '编辑文档' : '添加文档';
		$this->v = D('Conarc')->relation(true)->find($id);
		$this->selectType = selectType($this->v['fid']);		
		$imginfo = json_decode($this->v['conarc_body']['imgs']);//解json
		if($imginfo)
		{
			$imginfo = get_object_vars($imginfo); //对象转数组
			//重组数组		
			$arr = '';
			foreach($imginfo['file'] as $k=>$v)
			{
				$arr[$k]['file'] = $v;
			} 
			foreach($imginfo['sort'] as $k=>$v)
			{
				$arr[$k]['sort'] = $v;
			}
			foreach($imginfo['txt'] as $k=>$v)
			{
				$arr[$k]['txt'] = $v;
			}
			$arr = arraySort($arr, 'sort', 'asc'); //升序排列数组
			$this->imgs = $arr;	
		}
		else
		{
			$this->imgs = '';	
		}
		$jsons = json_decode($this->v['conarc_body']['json']);//解json
		if($jsons)
		{
			$this->j = get_object_vars($jsons); //对象转数组
		}
		else
		{
			$this->j = '';	
		}		
		$this->display();
    }
	//添加  编辑
	public function runSave($edit=''){
		$db = D("Conarc")->relation(true);
		$data['title'] = I('title');
		$data['shorttitle'] = I('shorttitle'); 
		$data['fid'] = I('fid'); 
		$data['click'] = I('click') ? I('click'): rand(11,99);		
		$data['flag'] = I('checkbox') ? implode(",",I('checkbox')) : '';
		$data['keywords'] = I('keywords',0) ? I('keywords') : I('title');
		$data['price1'] = I('price1'); 
		$data['price2'] = I('price2'); 
		$data['tpl'] = I('tpl');
		$data['description'] = I('description') ? I('description') : strip_tags(msubstr(I('content','',''), $start=0, 160, $charset="gbk", $suffix=false)); 
		$data['conarc_body']['body'] = str_replace(' style="text-indent:2em;"','',I('content','没有内容',''));	
		$data['img'] = I('img');
		$data['conarc_body']['imgs'] = json_encode(I('imginfo'));	
		$data['conarc_body']['json'] = is_array(I('jsons')) ? json_encode(I('jsons')) : I('jsons','没有内容','');
		
		//编辑
		if($edit)
		{	
			$data['id']=$edit;  		
			if($db->relation(true)->save($data))
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
			$data['pubdate'] = I('pubdate') ? strtotime(I('pubdate')) : time();			
			if($db->relation(true)->add($data))
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
		if(D('Conarc')->relation(true)->where(array('id' =>array( 'in', $id)))->delete())
		{
			$this->success('删除成功！');
		}	
		else
		{
			$this->error('删除失败！');
		}	
    }
}