<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name' => '12345',

	'defaultController'=>'ideas',
	
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.CAdvancedArBehavior',
		'application.extensions.ArrayUtils',
	),
	
	'modules'=>array(
                'user'=>array(
                        'hash' => 'md5',                                     # encrypting method (php hash function)
                        'sendActivationMail' => true,                        # send activation email
                        'loginNotActiv' => false,                            # allow access for non-activated users
                        'autoLogin' => true,                                 # automatically login from registration
                        'registrationUrl' => array('/user/registration'),    # registration path
                        'recoveryUrl' => array('/user/recovery'),            # recovery password path
                        'loginUrl' => array('/user/login'),                  # login form path
                        'returnUrl' => array('/ideas/myIdeas/'),               # page after login
                        'returnLogoutUrl' => array('/'),           # page after logout
                ),
        ),
	
	// application components
	'components'=>array(
		'loid' => array(
					   //alias to dir, where you unpacked extension
			'class' => 'application.extensions.lightopenid.loid',
		),
		

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl' => array('/user/login'),
		),
		// 'db'=>array(
			// 'connectionString' => 'sqlite:protected/data/testdrive.db',
		// ),
		// uncomment the following to use a MySQL database
		'cache' => array(
			'class' => 'CDbCache',
		),
		
		'db'=>array(
			'class' => 'system.db.CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=idea',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => '',
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
				
				array(
					'class'=>'CWebLogRoute',
				),
				
			),
		),
		
		'urlManager'=>array(
			'showScriptName' => false,
			'urlFormat' => 'path',
			'rules'=> array(
				'user/recovery/activkey/<activkey:.*?>/email/<email:.*?>' =>'user/recovery',
				'user/activation/activkey/<activkey:.*?>/email/<email:.*?>' =>'user/activation',
			
				'idea/<id:\d+>/<idea:.*?>' => 'ideas/view',
				'ideas/manage/user/<user:.*?>' => 'ideas/admin',
				'ideas/user/<user:.*?>' => 'ideas/user',
				'ideas/my-friends' => 'ideas/myFriendsIdeas',
				'idea/add/favorite/<id:\d+>' => 'ideas/addFavorite',
				'idea/remove/favorite/<id:\d+>' => 'ideas/removeFavorite',
				'ideas/my-favorites' => 'ideas/myFavoritesIdeas',
				'idea/search-user' => 'ideas/searchUser',
				'idea/search/s/<s:.*?>' => 'ideas/search',
				'idea/create' => 'ideas/create',
				'ideas/feed/user/<user:.*?>' => 'ideas/userFeed',
				'ideas/feeds' => 'ideas/allFeed',
				'ideas/my-friends-feeds' => 'ideas/myFriendsFeed',
				'ideas/my-favorites-feeds' => 'ideas/myFavoriteFeed',
				'idea/feed/<id:\d+>' => 'ideas/ideaFeed',
				'idea/convert/comment/<comment:\d+>' => 'ideas/convert',
				
				'friend/add/friend/<friend:.*?>' => 'friends/add',
				'friend/remove/friend/<friend:.*?>' => 'friends/remove',
				'user/my-friends' => 'friends/myFriends',
				
				
				
				'groups/user/<user:.*?>' => 'groups/user',
				'add/groups/friend/<friend:.*?>' => 'groups/addFriends',
				'remove/friend/<friend:\d+>/group/<group:\d+>/' => 'groups/removeFriend',
				'remove/idea/<idea:\d+>/group/<group:\d+>/' => 'groups/removeIdea',
				
				
				
				/*'ideas/<tag:.*?>' => 'ideas/index',*/
				
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
	
);