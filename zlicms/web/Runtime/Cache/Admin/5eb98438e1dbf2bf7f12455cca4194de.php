<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;"/>
<title><?php echo ($title); ?></title>
<link href="/web/Admin/View/css/base.css" rel="stylesheet" type="text/css">
<script src="/web/Admin/View/js/jquery.js"></script>
</head>

<body style="background:#fff">
<div class="login">
	<div class="loginTop">
    	<p><span class="s1">ZLI管理系统</span><span class="s2"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=178417451&Menu=yes" >帮助中心</a></span></p>
    </div>
    <div class="loginForm">
        <form name="login" action="" method="post" class="Validform">
            <dl>
                <dt>用户登录</dt>
                <dd>
                    <input class="user" type="text" name="user" datatype="*" ajaxurl="<?php echo U('login/is_verify',array('type'=>'user'));?>" errormsg="用户名不正确！"/>
                    <br>
                    <span class="Validform_checktip">输入登录用户</span></dd>
                <dd>
                    <input class="pw" type="password" name="password" datatype="*6-16" errormsg="密码不正确！"/>
                    <span class="Validform_checktip">输入登录密码</span></dd>
                <dd>
                    <input class="yzm fL" type="text" name="verify" datatype="*4-4"  ajaxurl="<?php echo U('login/is_verify',array('type'=>'verify'));?>" errormsg="验证码不正确！"/>
                    <img src="<?php echo U('login/verify');?>" alt="" align="absmiddle" onclick="this.src=this.src+'#'" style="cursor:pointer; width:90px; height:30px; float:left" id="vdimgck" />
                    <div class="clear"></div>
                    <span class="Validform_checktip">输入验证码</span></dd>
                <dd>
                    <input class="btn" type="submit" value="登  录" style="cursor:pointer" />
                </dd>
            </dl>
        </form>
    </div>
    <div class="loginBot">power by zli 版权所有</div>
</div>
<script src="/web/Admin/View/js/Validform.js"></script> 
<script type="text/javascript">
$(function(){	
	$(".Validform").Validform({
		tiptype:4
	});
})
</script>
</body>
</html>