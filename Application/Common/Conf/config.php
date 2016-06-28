<?php
return array(
	//'配置项'=>'配置值'
    'DEFAULT_CHARSET' => 'utf8',
    'session_auto_start' => true, //是否开启session
    'URL_CASE_INSENSITIVE' =>true, //路由不区分大小写

    'DB_FIELD_CACHE'=>false,
    'HTML_CACHE_ON'=>false,

    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'AppService', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '123', // 密码
    'DB_PORT'   =>  3306, // 端口
    'DB_PREFIX' => ' ', // 数据库表前缀
    'DB_CHARSET'=> 'utf8mb4', // 字符集
    'DB_DEBUG' => TRUE,
    'APP_WEB' =>"http://www.anumbrella.net/App/AppShopService",
);