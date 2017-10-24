<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
define('YII_ENV', 'test');
require('/var/www/html/vendor/autoload.php');
require('/var/www/html/vendor/yiisoft/yii2/Yii.php');

$config = require('/var/www/html/config/console.php');

//$application = new yii\console\Application($config);
//$exitCode = $application->run();
//exit($exitCode);
?>