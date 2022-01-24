<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Fleet Management System',
	//'name'=>array('ABC'),

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.user.models.*',
        'application.modules.user.components.*',
		
	),

	'modules'=>array(
            'user'=>array(
                'tableUsers' => 'tbl_users',
                'tableProfiles' => 'tbl_profiles',
                'tableProfileFields' => 'tbl_profiles_fields',
				
        ),
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','*'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true, 
			'loginUrl' => array('/user/login'),
                    
			
			),
		'email'=>array(
        	'class'=>'application.extensions.email.Email',
        	'delivery'=>'php'
			
			),
		
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=smsl_fleet_sqm',
			//'connectionString' => 'mysql:host=192.168.1.110;dbname=fleet_pension_27_1',
			
//            'connectionString' => 'mysql:host=localhost;dbname=skymanag_fleet',
			//'connectionString' => 'mysql:host=localhost;dbname=fleet_pension_ss',
			//'connectionString' => 'mysql:host=localhost;dbname=fleet_pension-deployedition',
			//'connectionString' => 'mysql:host=localhost;dbname=fleet_management_checking',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',

			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'companyName'=>'Squire Mech Engineering Pvt Ltd ',
		'Address'=>'No.135/1, Old Kottawa Rd,Nawinna, Maharagama ',
		'Tel'=>'0112851070, 0112839678, 0112839888 ',
		'Fax'=>' ',	
        'sysName_short'=>'Cirrus FMS',
		'sysName'=>'Fleet Management System',
	),
	
);