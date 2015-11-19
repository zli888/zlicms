<?php
	//权限判断
	function authcheck($name, $uid, $type=1, $mode='url', $relation='or'){
		//判断当前用户UID是否在定义的超级管理员参数里
		if($uid==1)
		{    
			return true;    //如果是，则直接返回真值，不需要进行权限验证
		}		
		else
		{
			//如果不是，则进行权限验证；
			static $Auth    =   null;
			if (!$Auth) {
				$Auth       =   new \Think\Auth();
			}
			return $Auth->check($name, $uid, $type, $mode, $relation)?true:false;
		}
    }	
	//当前菜单判断
	function is_select($id='',$top=0){
		$rule  = strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME);
		$navid = M('admin_rule')->where(array('name'=>$rule))->find();
		$fid=getTop_rule($navid['id']); 
		if($top)
		{			
			if($id==$fid)
			{
				return 'style="display:block"';
			}
			else
			{
				return false;
			}
		}
		else
		{
			if($id==$navid['id'] || $id==$navid['fid'])
			{
				return 'class="select"';
			}
			else
			{
				return false;
			}
		}
	}
	//操作选择
	function select_rule($id) {
		$type = M('admin_rule')->order('id asc')->cache('select_rule')->select();
		$type = \Extend\Category::unlimitLevel($type,'fid','id');
		$options = "<option value='0'>==请选择==</option>";
		foreach ($type as $v)
		{
			$options .= "<option value='".$v['id']."'".($v['id']==$id ? ' selected="selected"' : '').">".$v['html'].$v['title']."</option>";
		}
		return $options;
	}
	//获取操作子id
	function get_rule($id)
	{
		$type = M('admin_rule')->order('id asc')->cache('admin_rule')->select();	
		$types = new \Extend\Category();  
		$type = $types->getSon($type,'fid','id',$id);
		$type = implode(',',$type);
		if($type)
		{
			return $id.','.$type;
		}
		else
		{
			return $id;
		}
	}	
	//获取操作topid
	function getTop_rule($id)
	{	
		$type = M('admin_rule')->order('id asc')->cache('gettoprule')->select();
		$types = new \Extend\Category(); 	
		$type = $types->getFather($type,'fid','id',$id);
		foreach ($type as $v)
		{
			if($v['fid']==0)
			{
				$id = $v['id'];
			}
		}
		return $id;
	}
	
	/*
	下拉选择
	$id : 当前id
	$table : 数据表
	$field : 输出的字段
	$fieldid ： 查询字段id
	$fieldfid ： 查询字段父id
	*/
	function selectOption($id,$table,$field='',$fieldid='id',$fieldfid='fid') {
		$type = M($table)->order($fieldid.' asc')->cache('selectOption')->select();
		$type = \Extend\Category::unlimitLevel($type,$fieldfid,$fieldid);
		$options = "<option value='0'>==请选择==</option>";
		foreach ($type as $v)
		{
			$options .= "<option value='".$v[$fieldid]."'".($v[$fieldid]==$id ? ' selected="selected"' : '').">".$v['html'].$v[$field]."</option>";
		}
		return $options;
	}	
	//获取用户组成员
	function getUser($groupid='',$uid='')
	{		
		$where = '';
		if($groupid)
		{
			$groupid = explode(",",$groupid); 
			foreach ($groupid as $vid)
			{
				$where.= 'group_id='.$vid.' or ';
			}	
			$where .= ' group_id = 0 ';		
		}
		else
		{
			$where = ' 1 ';
		}
		$users = D('AdminView')->where($where)->select();
		$options = "<option value=''>==请选择==</option>";
		foreach ($users as $v)
		{
			$options .= "<option value='".$v['uid']."'".($v['uid']==$uid ? ' selected="selected"' : '').">".$v['username']."</option>";
		}
		return $options;
	}	
	//根据表、id获取字段值
	function getField($table='',$field1='',$field2='',$id=''){			
		$result = M($table)->where(array($field1=>$id))->find();
		echo $result[$field2];
    }
	//根据表、id获取子id
	function getSons($table='',$id='')
	{
		$arr=explode(",",$id);
		$ids = '';		
		foreach($arr as $id)
		{	
			$type = M($table)->order('id asc')->select();		
			$type = \Extend\Category::getSon($type,'tid','id',$id);
			$type = implode(',',$type);
			if($type)
			{
				$ids .= $id ? $id.','.$type.',' : $type.',';				
			}
			else
			{
				$ids .=$id.',';				
			}
		}
		return substr($ids,0,strlen($ids)-1);
	}	
	//时间截
	function getTimecut($n){
		$ret=array();
		switch($n){
			case "jt":// 今天
				$ret['sdate']=date('Y-m-d 00:00:00');
				$ret['edate']=date('Y-m-d H:i:s');
			break;
			case "zt":// 昨天
				$ret['sdate']=date('Y-m-d 00:00:00',time()-86400);
				$ret['edate']=date('Y-m-d 23:59:59',time()-86400);
			break;
			case "bz"://本周
				$ret['sdate']=date("Y-m-d 00:00:00",time()-(date("w")-1)*86400);
				$ret['edate']=date('Y-m-d H:i:s');
			break;
			case "sz"://上周
				$ret['sdate']=date("Y-m-d 00:00:00",time()-(date("w")+6)*86400);
				$ret['edate']=date('Y-m-d 23:59:59',time()-date("w")*86400);
			break;       
			case "by": //本月
				$ret['sdate']=date("Y-m-d 00:00:00",time()-(date("d")-1)*86400);
				$ret['edate']=date('Y-m-d H:i:s');
				break;
			case "sy"://上月			
				$ret['sdate']=date('Y-m-01  00:00:00',strtotime(date('Y',time()).'-'.(date('m',time())-1).'-01'));
				$ret['edate']=date('Y-m-d  23:59:59',strtotime($ret['sdate']." +1 month -1 day"));
			break;
			case "sytq"://上月同期	
				$retd=date('Y-m-01 H:i:s',strtotime(date('Y',time()).'-'.(date('m',time())-1).'-01'."  ".date('H',time()).":".date('i',time()).":".date('s',time())));		
				$ret['sdate']=date('Y-m-01  00:00:00',strtotime(date('Y',time()).'-'.(date('m',time())-1).'-01'));
				$ret['edate']=date("Y-m-d H:i:s",strtotime($retd)+(date("d")-1)*86400);
			break;
			case "all"://所有
				$ret['sdate']=date('1970-1-1 00:00:00');
				$ret['edate']=date('Y-m-d H:i:s');
			break;
		}	
		return $ret;
	}
	//判断月份天数
	//$dateStr:时间戳
	function getMonthDays($dateStr)
	{
		if (in_array(date('m',$dateStr), array(1, 3, 5, 7, 8, 01, 03, 05, 07, 08, 10, 12)))
		{  
            $days = 31;  
		}
		else if (date('m',$dateStr) == 2)
		{  
            if (date('Y',$dateStr) % 4 == 0) {        //判断是否是闰年  
                $days = 29;  
            }
			else
			{  
                $days = 28;  
            }  
        }
		else
		{  
            $days = 30;  
        }	
		return $days;
	}
	//百度收录查询
	function checkBaidu($url){
		$url = 'http://www.baidu.com/s?wd='.$url;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$rs = curl_exec($curl);
		curl_close($curl);
		$arr = parse_url($url);
		$result = 0;
		//print_r($arr);
		if (strpos($arr['query'], 'http://')) {
			$arr['query'] = str_replace('http://', '', str_replace('wd=', '', $arr['query']));
		} else {
			$arr['query'] = str_replace('wd=', '', $arr['query']);
		}	
		if (strpos($arr['query'], '?')) {
			$str = strstr($arr['query'], '?');
			$arr['query'] = str_replace($str, '', $arr['query']);
		}	
		if (strpos($arr['query'], '/')) {
			$narr = explode('/', $arr['query']);
			$arr['query'] = $narr[0];
		}
		//echo $rs.'-'.$arr['query'];
		if (strpos($rs, 'sitesubmit')) {
			$result = -1;
		} else {
			$result = 1;
		}
		return $result;
	}
?>