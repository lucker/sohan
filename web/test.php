<?php
/**
 * Yii console bootstrap file.
 *
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
$f=$_SERVER['DOCUMENT_ROOT'];
require($f . '/vendor/autoload.php');
require($f . '/vendor/yiisoft/yii2/Yii.php');

$config = require($f . '/config/console.php');

// ЗДЕСЬ!!! Вставленный нами код
if( isset($_GET['r']) and !empty($_GET['r'])){
	$_SERVER['argv'] =  [
                                '~/home/dev/www/projectFolder/yii',
                                $_GET['r']
                            ];
	$_SERVER['argc'] = 2;
}

$application = new yii\console\Application($config);
$exitCode = $application->run();
exit($exitCode);