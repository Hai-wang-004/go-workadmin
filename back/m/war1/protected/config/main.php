<?php
$basePath = dirname(__FILE__).DIRECTORY_SEPARATOR.'..';
return array(
	'language'=>'zh_cn',
	'basePath'=>$basePath,
	'charset'=>'utf-8',
	'timeZone'=>'Asia/Chongqing',
	'name'=>'房销宝',
	'preload'=>array('log'),
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),
	'defaultController'=>'index',
	
	'modules'=>array(
		/* 'gii'=>array(
		 	'class'=>'system.gii.GiiModule',
		 	'password'=>false,
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
		 	//'ipFilters'=>array('127.0.0.1','::1'),
		 	'generatorPaths'=>array(
		 	//	'system.gii.generators',
                   'application.gii',  
               ),
		 ),*/
		
	),
	
	
	'components'=>array(
		'clientScript' => array(
			'enableJavaScript' => false
		),
		'user'=>array(
			'allowAutoLogin'=>true,
		),
		'db'=>array(
			'connectionString' => 'mysql:host=192.168.242.165;dbname=focus_fxb',
			'username' => 'focus_fxb',
			'password' => 'vc356vf',
			'charset' => 'utf8',
			'emulatePrepare' => true,
			'tablePrefix' => 'fxb_',
		),
		
		'db2'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=focus_fxb',
			'username' => 'root',
			'password' => '123456',
			'charset' => 'utf8',
			'emulatePrepare' => true,
			'tablePrefix' => 'fxb_',
			'enableParamLogging' => true,
		),
		
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
		/*'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				'setcookie' => 'login/setcookie',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),*/
		/*'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),*/
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				/*array(
					'class'=>'CWebLogRoute',
					'levels'=>'trace, info error, warning',     //级别为trace
					'categories'=>'system.db.*' //只显示关于数据库信息,包括数据库连接,数据库执行语句
				),*/
				
			),
		),
		
		'cache' => array(  
    		'class' => 'CFileCache',  
    		'cachePath'=> $basePath.'/runtime/fileCache', 
    		'directoryLevel'=>2,
		),
	),
	'params'=>require(dirname(__FILE__).'/params.php'),
);