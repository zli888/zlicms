<?php
namespace Extend;
class Category {
	//组合二维数组
	//$cate：  传入的数组
	//$html：  级别符号
	//$id： 父id值
	//$fid：父id字段名
	//$sid：子id字段名
	//$level： 级别
	static public function unlimitLevel($cate,$fid,$sid,$id=0,$html=' — ',$level=0)
	{
		$arr = array();
		foreach ($cate as $v)
		{
			if($v[$fid] == $id)
			{
				$v['level'] = $level + 1;
				$v['html'] = str_repeat($html,$level);
				$arr[] = $v;
				$arr = array_merge($arr,self::unlimitLevel($cate,$fid,$sid,$v[$sid],$html,$level+1));			
			}		
		}	
		return $arr;	
	}
	
	//组合多维数组
	//$cate：  传入的数组
	//$id： 父id值
	//$fid：父id字段名
	//$sid：子id字段名
	//$name： 压入的数组
	static public function unlimitLayer($cate,$fid,$sid,$id=0,$name='son')
	{
		$arr = array();
		foreach ($cate as $v)
		{
			if($v[$fid] == $id)
			{
				$v[$name] = self::unlimitLayer($cate,$fid,$sid,$v[$sid],$name);				
				$arr[] = $v;					
			}		
		}	
		return $arr;	
	}
	
	//根据子分类获取父分类
	//$cate：  传入的数组
	//$id： 子id值
	//$fid：父id字段名
	//$sid：子id字段名
	static public function getFather($cate,$fid,$sid,$id)
	{
		$arr = array();
		foreach ($cate as $v)
		{
			if($v[$sid] == $id)
			{
				$arr[] = $v;
				$arr = array_merge(self::getFather($cate,$fid,$sid,$v[$fid]),$arr);
			}		
		}	
		return $arr;	
	}
	
	//根据父分类获取子分类
	//$cate：  传入的数组
	//$id： 父id值
	//$fid：父id字段名
	//$sid：子id字段名
	static public function getSon($cate,$fid,$sid,$id)
	{
		$arr = array();
		foreach ($cate as $v)
		{
			if($v[$fid] == $id)
			{
				//$arr[] = $v;
				$arr[] = $v[$sid];
				$arr = array_merge($arr,self::getSon($cate,$fid,$sid,$v[$sid]));								
			}		
		}	
		return $arr;	
	}
}

?>