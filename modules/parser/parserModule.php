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
        include $_SERVER['DOCUMENT_ROOT']."/parser/simple_html_dom.php";
        include $_SERVER['DOCUMENT_ROOT']."/parser/phpQuery.php";

        parent::init();

        // custom initialization code goes here
    }
}
