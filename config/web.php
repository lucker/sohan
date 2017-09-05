<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'parser' => [
            'class' => 'app\modules\parser\parserModule',
        ],
        'prognoz' => [
            'class' => 'app\modules\prognoz\prognoz',
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'baseUrl' => '',
            'cookieValidationKey' => '1q2w3e4r5t',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
		'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'user' => [
            'identityClass' => 'app\models\users',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
			//'catchAll' => ['site/offline'],
			/*'graph/<id>'=>'graph/graph',
			'articles/test'=>'articles/test',
			'prognoz/view' =>'prognoz/view',
			'prognoz/p' =>'prognoz/p',
			'prognoz/add' =>'prognoz/add',
			'prognoz/prate' =>'prognoz/prate',
			'prognoz/matches' =>'prognoz/matches',
			'prognoz/rates' =>'prognoz/rates',
			'prognoz/addp' =>'prognoz/addp',
			'prognoz/index' =>'prognoz/index',
			'prognoz/bot' =>'prognoz/bot',
                'prognoz/create' => 'prognoz/create',
			'articles/<name>'=>'articles/view',
			'prognoz/<id>'=>'prognoz/pview',*/
            ],
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['93.74.90.49', '91.211.122.130'] // регулируйте в соответствии со своими нуждами
    ];
}

return $config;