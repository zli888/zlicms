<?php
return array(
	 /* 数据库设置 */
	'DB_TYPE'   => 'mysqli', // 数据库类型
	'DB_HOST'   => '127.0.0.1', // 服务器地址
	'DB_NAME'   => 'zlicms', // 数据库名
	'DB_USER'   => 'zlicms', // 用户名
	'DB_PWD'    => 'zhangli888', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => 'zl_', // 数据库表前缀
	
	/* 模板引擎设置 */
    'TMPL_ACTION_ERROR'     =>  'tpl/prompt/dispatch_jump.html', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   =>  'tpl/prompt/dispatch_jump.html', // 默认成功跳转对应的模板文件
    'TMPL_EXCEPTION_FILE'   =>  'tpl/prompt/think_exception.html',// 异常页面的模板文件
    'TMPL_FILE_DEPR'        =>  '_', //模板文件CONTROLLER_NAME与ACTION_NAME之间的分割符	
	'AUTOLOAD_NAMESPACE' => array(
	    'Extend'     => __ROOT__.'extend',   //扩展类路径
	),	
);