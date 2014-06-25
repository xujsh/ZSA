<?php
return array(
	//'配置项'=>'配置值'
	'VAR_FILTERS'=>'strip_tags',
	'APP_GROUP_LIST' => '"",Jingxue',
    'DEFAULT_GROUP'  => '',
	'DB_TYPE'   => 'pdo', // 数据库类型

	//'DB_USER'   => 'bjdevapp', // 用户名
	//'DB_PWD'    => 'bjdevappmysql', // 密码

	'DB_USER'   => 'root', // 用户名
	'DB_PWD'    => '111111', // 密码

	//'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => '', // 数据库表前缀
	'DB_DSN'    => 'mysql:host=127.0.0.1;dbname=jingstudy',

	'APP_DOMAIN' =>'jingstudy.test.icesmart.cn',							//域名
	'APP_BASE_URI' => '/',													//根
	'APP_SITE_URI'=> 'http://jingstudy.test.icesmart.cn',					//完整域名
    'USER_NEED_LOGIN'=> '/Needlogin',										//返回登录
	'RETURN_USER_NOTICE'=>'/Goback',										//后退
    'M3U8_DIR'=>'/opt/web/media/nginx/',									//m3u8播放绝对路径
    'PlAY_URI'=>'http://jingstudy.test.icesmart.cn:8081/',					//hls服务器地址
	'UPLOAD_DIR' => '/opt/web/jingstudy.test.icesmart.cn/webroot/Uploads/', //上传地址
	'UPLOAD_URI' => '/Uploads/',
	'RESOURCE_DIR'=>'/opt/web/jingstudy.test.icesmart.cn/webroot/GResources/', //资源库地址
	'RESOURCE_URL'=>'/GResources/',
	'TMPL_EXCEPTION_FILE'=>'status.html',

	'DATA_CACHE_TYPE' => 'Memcached',
	'DATA_CACHE_TIME' => 60,
	'MEMCACHE_HOST' => 'localhost',
	'MEMCACHE_PORT' => '11211',

    'SESSION_OPTIONS'=>array('expire'=>3600),
	'SHOW_RUN_TIME'    => false,
	'SHOW_DB_TIMES'    => false,
	'SHOW_CACHE_TIMES' => false,
	'SHOW_PAGE_TRACE' => false
);
?>
