<?php if (!defined('THINK_PATH')) exit(); if(C('LAYOUT_ON')) { echo ''; } ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;"/>
<title>跳转提示</title>
<style>
html,body,div,dl, dt, dd, p { margin:0; padding:0; font-family: arial,"Hiragino Sans GB","Microsoft Yahei",sans-serif; color:#333; font-size:14px;}
.main { width:300px; height:160px; position:fixed; left:50%; top:50%; margin:-60px 0 0 -150px;}
.main dt { font-size:18px; text-align:center; background:#f1f1f1; border:1px solid #ccc; font-weight:bold; line-height:40px; border-radius:10px 10px 0 0}
.main dd { padding:10px 0 10px 20px; border:1px solid #ccc; border-top:0}
.main p {  padding:30px 0 30px 100px; background-position:left center; background-repeat:no-repeat; background-size:80px; font-size:14px;}
.main .right {background-image:url(/tpl/prompt/right.png);}
.main .error {background-image:url(/tpl/prompt/error.png);}
</style>
</head>

<body>
<div class="main">
	<dl>
    	<dt>跳转提示</dt>
        <dd>
        	<?php if(isset($message)): ?><p class="right"><?php echo($message); ?></p>
            <?php else: ?>
            <p class="error"><?php echo($error); ?></p><?php endif; ?>
            <span>页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b></span>
        </dd>
    </dl>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body>
</html>