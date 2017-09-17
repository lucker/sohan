<?php

namespace app\modules\parser;

/**
 * parser module definition class
 */
class parserModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\parser\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        //phpQuery для парсинга
        include "/var/www/html/parser/phpQuery.php";
        parent::init();
    }
}
