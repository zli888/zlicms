//获得选中文件的文件名
function getCheckboxItem()
{
	var allSel="";
	if(document.CheckboxForm.aid.value) return document.CheckboxForm.aid.value;
	for(i=0;i<document.CheckboxForm.aid.length;i++)
	{
		if(document.CheckboxForm.aid[i].checked)
		{
			if(allSel=="")
				allSel=document.CheckboxForm.aid[i].value;
			else
				allSel=allSel+","+document.CheckboxForm.aid[i].value;
		}
	}
	return allSel;	
}
function selAll()
{
	for(i=0;i<document.CheckboxForm.aid.length;i++)
	{
		document.CheckboxForm.aid[i].checked=true;
	}
}
function selNone()
{
	for(i=0;i<document.CheckboxForm.aid.length;i++)
	{
		document.CheckboxForm.aid[i].checked=false;
	}
}
function selNor()
{
	for(i=0;i<document.CheckboxForm.aid.length;i++)
	{
		if(document.CheckboxForm.aid[i].checked==false)
			document.CheckboxForm.aid[i].checked=true;
		else
			document.CheckboxForm.aid[i].checked=false;
		
	}
}
/*// 删除
function delCheckboxForm()
{
	var qstr=getCheckboxItem();
	if(qstr=="") alert("你没选中任何内容！");
	else if(window.confirm('你确定要删除吗?')) location.href="?job=del&id="+qstr;
}
// 审核
function passCheckboxForm()
{
	var qstr=getCheckboxItem();
	if(qstr=="") alert("你没选中任何内容！");
	else location.href="?job=pass&id="+qstr;
}*/