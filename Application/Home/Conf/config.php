<?php
return array(
	'DB_TYPE'      =>  'mysql',     // 数据库类型
	'DB_HOST'      =>  'localhost',     // 服务器地址
	'DB_NAME'      =>  'solarstory',     // 数据库名
	'DB_USER'      =>  'root',     // 用户名
	'DB_PWD'       =>  'deswan',     // 密码
	'DB_PORT'      =>  3306,     // 端口
	'DB_PREFIX'    =>  '',     // 数据库表前缀
	'DB_DSN'       =>  '',     // 数据库连接DSN 用于PDO方式
	'DB_CHARSET'   =>  'utf8', // 数据库的编码 默认为utf8

	'TMPL_L_DELIM'    =>    '<{',
	'TMPL_R_DELIM'    =>    '}>',

	'DEFAULT_FILTER'        => 'htmlspecIalchars',
	'SESSION_AUTO_START'    =>  true,
	'URL_PARAMS_BIND'       =>  true,
	'SHOW_PAGE_TRACE' =>true,

	'QINIU_ACCESS_KEY'      =>  'u96ZzUDhCie7PRiSeKOA2A17DTsL2yY7NutVb9gg',
    'QINIU_SECRET_KEY'      =>  'l_aHIXz52e2g5UNNnL9_lOa89EHCKFN8Fg1nCrwM',
    'QINIU_DOMAIN'          =>  'http://7xn3su.com1.z0.glb.clouddn.com',
);