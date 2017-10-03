<?php

namespace app\modules\parser\controllers;

use app\modules\parser\models\melbet;
use yii\web\Controller;
use yii;
use app\modules\parser\models\marathonbet;
use app\modules\parser\models\sportingbetru;
use app\modules\parser\models\xbet;
use app\modules\parser\models\leonbets;
use app\modules\parser\models\proxy;
use app\modules\parser\models\vilki;

use app\modules\parser\models\insertEvents;
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
    public function actionCheckproxy()
    {
        $proxy = new proxy;
        $proxy->testProxy();
    }
    //
    public function actionTest()
    {
        $vilki = new vilki();
        $vilki->checkOldVilki();
    }
    //
    public function actionMarathonbetLeagesParsing()
    {
        header('X-Accel-Buffering: no');
        $start = microtime(true);
        $marathon = new marathonbet();
        $marathon->getLeages();
        echo 'Время выполнения скрипта(events): ' . (microtime(true) - $start) . ' сек.';
    }
    //
    public function actionMarathonbetMatchesParsing()
    {
        $start = microtime(true);
        $marathon = new marathonbet();
        $marathon->getMatches();
        echo 'Время выполнения скрипта(events): ' . (microtime(true) - $start) . ' сек.';
    }
    //
    public function actionMarathonbetEventsParsing()
    {
        /*$parsing = \Yii::$app->db
            ->createCommand('
                SELECT `parsing` FROM `bukcontor`
                WHERE `id` = :id', [
                    ':id' => 2
                ])->queryScalar();
        if (!$parsing) {*/
            $start = microtime(true);
            $marathon = new marathonbet();
            $marathon->getEvents();
            echo 'Время выполнения скрипта(events): ' . (microtime(true) - $start) . ' сек.';
        //}
    }
    //
    public function actionXbetLeagesParsing()
    {
        // вечный цикл в фоне работает
            $start = microtime(true);
            $xbet = new xbet();
            $xbet->getLeages();
            echo 'Время выполнения скрипта(events): ' . (microtime(true) - $start) . ' сек.';
    }
    //
    public function actionXbetMatchesParsing()
    {
        $start = microtime(true);
        $xbet = new xbet();
        $xbet->getMatches();
        echo 'Время выполнения скрипта(events): ' . (microtime(true) - $start) . ' сек.';
    }
    //
    public function actionXbetEventsParsing()
    {
        // header('X-Accel-Buffering: no');
        $xbet = new xbet();
        // while (1) {
        $xbet->getEvents();
        //    sleep(30);
        // }
    }
    //
    public function actionSportingbetLeagesParsing()
    {
        header('X-Accel-Buffering: no');
        $start = microtime(true);
        $sportingbet = new Sportingbetru();
        $sportingbet->getLeages();
        echo 'Время выполнения скрипта(events): ' . (microtime(true) - $start) . ' сек.';
    }
    //
    public function actionSportingbetMatchesParsing()
    {
        // header('X-Accel-Buffering: no');
            $start = microtime(true);
            $sportingbet = new Sportingbetru();
            $sportingbet->getMatches();
            echo 'Время выполнения скрипта(events): ' . (microtime(true) - $start) . ' сек.';
    }
    //
    public function actionSportingbetEventsParsing()
    {
        //header('X-Accel-Buffering: no');
        $sportingbet = new Sportingbetru();
        $sportingbet->getEvents();
    }
    //
    public function actionLeonbetsMatchesParsing()
    {
        $leonbets = new leonbets();
        $leonbets->getMatches();
    }
    //
    public function actionLeonbetsLeagesParsing()
    {
        $leonbet = new leonbets();
        $leonbet->getLeages();
    }
    //
    public function actionLeonbetsEventsParsing()
    {
        $leonbet = new leonbets();
        while (1) {
            $leonbet->getEvents();
            sleep(30);
        }
    }
    //
    public function actionMelbetLeagesParsing()
    {
        $melbet = new melbet();
        $melbet->getLeages();
    }
    //
    public function actionMelbetMatchesParsing()
    {
        header('X-Accel-Buffering: no');
        $melbet = new melbet();
        $melbet->getMatches();
    }
    //
    public function actionMelbetEventsParsing()
    {
        $melbet = new melbet();
        $melbet->getEvents();
    }
    //
    public function actionVilki()
    {
        $vilki = new vilki();
        $vilki->mixed();
    }
}
