<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo ($title); ?></title>
<link href="/web/Admin/View/css/base.css" rel="stylesheet" type="text/css">
<script src="/web/Admin/View/js/jquery.js"></script>
<script src="/web/Admin/View/js/effect.js"></script>
<script src="/web/Admin/View/js/base.js"></script>
<script language="javascript">
// 删除
function delCheckboxForm()
{
	var qstr=getCheckboxItem();
	if(qstr=="") alert("你没选中任何内容！");
	else if(window.confirm('你确定要删除吗?')) location.href="<?php echo U('del');?>?id="+qstr;
}
// 禁用
function disableCheckboxForm()
{
	var qstr=getCheckboxItem();
	if(qstr=="") alert("你没选中任何内容！");
	else location.href="<?php echo U('job',array('job'=>'disable'));?>?id="+qstr;
}
// 启用
function passCheckboxForm()
{
	var qstr=getCheckboxItem();
	if(qstr=="") alert("你没选中任何内容！");
	else location.href="<?php echo U('job',array('job'=>'pass'));?>?id="+qstr;
}
</script>
</head>

<body>
<div class="header"> <a href="<?php echo U('Index/index');?>" class="logo fL"></a><a href="<?php echo U('Index/index');?>" class="fL">ZLICMS管理控制台</a>
    <div class="user"> <?php echo session('admin.username');?>    |  <a href="<?php echo U('login/logout');?>">退出</a></div>
</div>
<div class="nav">
	<?php if(is_array($menu)): foreach($menu as $key=>$m): ?><h3><em></em><?php echo ($m['title']); ?></h3>
        <ul <?php echo is_select($m['id'],1);?>>
            <?php if(is_array($m["son"])): foreach($m["son"] as $key=>$s): ?><li <?php echo is_select($s['id']);?>><a href="<?php echo U($s['name']);?>"><?php echo ($s['title']); ?></a></li><?php endforeach; endif; ?>
        </ul><?php endforeach; endif; ?>    
</div>
<script type="text/javascript">
	var ary = location.href.split("&");
	jQuery(".nav").slide({titCell:"h3", targetCell:"ul",defaultIndex:1,effect:"slideDown",delayTime:300,trigger:"click",defaultPlay:false});
</script>
<div class="main">
	<div class="info">
        <div class="tit"><?php echo ($title); ?><a class="add" href="<?php echo U('save');?>"> 添加 </a></div>
        <p>提示：禁止重复添加</p>
    </div>
    <div class="list mT10">
    <form name="CheckboxForm" action="" method="post">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr class="tit2 bg">
                <td width="10%">ID</td>
                <td width="10%">选择</td>
                <td width="50%">名称</td>
                <td width="10%">文档数量</td>
                <td width="10%">状态</td>
                <td width="20%">操作</td>    
            </tr>   
            <?php if(is_array($type)): foreach($type as $key=>$v): ?><tr onmousemove="javascript:this.bgColor='#d2e8fb';" onmouseout="javascript:this.bgColor='';">
                <td><?php echo ($v['id']); ?></td>
                <td><input name="id" type="checkbox" id="aid" value="<?php echo ($v['id']); ?>"></td>
                <td class="tL"><?php echo ($v['level']>1 ? '└' : ''); echo ($v['html']); echo ($v['name']); ?></td>
                <td>文档数量</td>
                <td><?php echo ($v['status'] ? '启用' :'<font color="#FF0000">禁用</font>'); ?></td> 
                <td align="center">                    
                    <a class="edit" href="<?php echo U('save',array('edit'=>$v['id']));?>"></a>
                    <a class="del" href="<?php echo U('del',array('id'=>$v['id']));?>" onclick="return confirm('确实要删除吗？')"></a>
                    <a class="look" href=""></a>
                </td>         
            </tr><?php endforeach; endif; ?>   
            <tr>
                <td colspan="9" class="pagelist"></td>
            </tr>
            
                <td colspan="9" class="tit"><input type='button' class="coolbg"  value='全选' onClick="selAll()" />
                    <input type='button' class="coolbg"  value='取消' onClick="selNone()" />
                    <input type='button' class="coolbg"  value='反选' onClick="selNor()"  />
                    <input type='button' class="coolbg"  value=' 删除 ' onClick="delCheckboxForm()" />
                    <input type='button' class="coolbg"  value=' 启用 ' onClick="passCheckboxForm()" />
                    <input type='button' class="coolbg"  value=' 禁用 ' onClick="disableCheckboxForm()" /></td>
        </table>
    </form> 
    </div>   
</div>
</body>
</html>