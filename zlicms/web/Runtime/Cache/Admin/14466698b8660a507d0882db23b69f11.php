<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;"/>
<title><?php echo ($title); ?></title>
<link href="/web/Admin/View/css/base.css" rel="stylesheet" type="text/css">
<script src="/web/Admin/View/js/jquery.js"></script>
<script src="/web/Admin/View/js/effect.js"></script>
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
    
</div>
</body>
</html>