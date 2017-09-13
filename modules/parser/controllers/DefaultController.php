<?php

namespace app\modules\parser\controllers;

use yii\web\Controller;
use app\modules\parser\models\marathonbet;
use app\modules\parser\models\sportingbetru;
use app\modules\parser\models\xbet;
use app\modules\parser\models\leonbets;

use app\modules\parser\models\proxy;
/**
 * Default controller for the `parser` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $layout = 'main';
    //
    public function actionLeonbets()
    {
        $leonbet = new leonbets();
        $leages = $leonbet->getLeages();

    }
    //
    public function actionCheckproxy()
    {
        $proxy = new proxy;
        $proxy->testProxy();
    }
    //
    public function actionTest()
    {
        $start = microtime(true);
        $marathon = new marathonbet();
        //$marathon->getLeages();
        //$marathon->getMatches();
        //$marathon->getEvents();
        echo 'Время выполнения скрипта(events): ' . (microtime(true) - $start) . ' сек.';
    }
    //
    public function actionMarathonbetleagesparsing()
    {
        $marathon = new marathonbet();
        $marathon->getLeages();
    }
    //
    public function actionMarathonbetmatchesparsing()
    {
        $start = microtime(true);
        $marathon = new marathonbet();
        $marathon->getMatches();
        echo 'Время выполнения скрипта(events): ' . (microtime(true) - $start) . ' сек.';
    }
    //
    public function actionMarathonbeteventsparsing()
    {
        $marathon = new marathonbet();
        $marathon->getEvents();
    }
    //
    public function actionXbetleagesparsing()
    {
        $xbet = new xbet();
        $xbet->getLeages();
    }
    //
    public function actionXbetmatchesparsing()
    {
        $xbet = new xbet();
        $xbet->getMatches();
    }
    //
    public function actionSportingbetleagesparsing()
    {
        $sportingbet = new Sportingbetru();
        $sportingbet->getLeages();
    }
    //
    public function actionSportingbetmatchesparsing()
    {
        $sportingbet = new Sportingbetru();
        $sportingbet->getMatches();
    }
    //
    public function actionSportingbeteventsparsing()
    {
        $start = microtime(true);
        $sportingbet = new Sportingbetru();
        $sportingbet->getEvents();
        echo 'Время выполнения скрипта(events): ' . (microtime(true) - $start) . ' сек.';
    }
}
