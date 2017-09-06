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
    public function actionSportingbet()
    {
        $parsing = \Yii::$app->db
            ->createCommand('
                SELECT `parsing` FROM `bukcontor`
                WHERE `id` = :id', [
                ':id' => 3,
            ])->queryScalar();
        if (!$parsing) {
            $start = microtime(true);
            $sportingbetru = new sportingbetru;
            $leages = $sportingbetru->getLeages();
            $matches = $sportingbetru->getMatches($leages);
            $sportingbetru->getEvents($matches);
            echo 'Время выполнения скрипта: ' . (microtime(true) - $start) . ' сек.';
        }
    }
    //
    public function actionXbet()
    {
        $parsing = \Yii::$app->db
            ->createCommand('
                SELECT `parsing` FROM `bukcontor`
                WHERE `id` = :id', [
                ':id' => 1,
            ])->queryScalar();
        if (!$parsing) {
            $start = microtime(true);
            $xbet = new xbet;
            $leages = $xbet->getLeages();
            $matches = $xbet->getMatches($leages);
            $xbet->getEvents($matches);
            echo 'Время выполнения скрипта: '.(microtime(true) - $start).' сек.';
        }
    }
    //
    public function actionMarathonbet()
    {
        $parsing = \Yii::$app->db
            ->createCommand('
                SELECT `parsing` FROM `bukcontor`
                WHERE `id` = :id', [
                ':id' => 2,
            ])->queryScalar();
        if (!$parsing) {
            $start = microtime(true);
            $marathonbet = new marathonbet;
            $leages = $marathonbet->getLeages();
            /*echo "<pre>";
            print_r($leages);
            echo '<pre>';*/
            $matches = $marathonbet->getMatches($leages);
            $marathonbet->getEvents($matches);
            echo 'Время выполнения скрипта(events): ' . (microtime(true) - $start) . ' сек.';
        }
    }
    //
    public function actionLeonbets() {
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
    }
}
