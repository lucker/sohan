<?php

namespace app\modules\parser\controllers;

use app\modules\parser\models\melbet;
use yii\web\Controller;
use yii;
use app\modules\parser\models\marathonbet;
use app\modules\parser\models\sportingbetru;
use app\modules\parser\models\xbet;
use app\modules\parser\models\leonbets;
use app\modules\parser\models\bet365;
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

        $bet365 = new bet365();
        $url = [];
        $url[] = [
            'href' => 'https://www.bet365.com/SportsBook.API/web?lid=1&zid=9&pd=%23AC%23B1%23C1%23D8%23E67511802%23F3%23H0%23I1%23R1&cid=195&cgid=1'
        ];
        $channels = $bet365->proceedUrls($url);
        foreach ($channels as $key => $channel) {
            $html = curl_multi_getcontent($channel);
            if ($html) {
                $json = $bet365->decode(gzdecode($html));
                echo '<pre>';
                print_r($json);
                echo '</pre>';
                $fullTime = false;
                $doubleChange = false;
                foreach ($json as $keyValue => $value) {
                    switch ($value['NA']) {
                        case 'Full Time Result':
                            $od = $bet365->fractionToDecimal($json[$keyValue+2]['OD']);

                            //echo 'od='.$od.' ';
                            break;
                        case 'Double Chance':
                            $od = $bet365->fractionToDecimal($json[$keyValue+2]['OD']);

                            //echo 'od='.$od.' ';
                            break;
                    }
                    if ($fullTime&&$doubleChange) {
                        break;
                    }
                }
            }
        }

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
        // header('X-Accel-Buffering: no');
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
        $leonbet->getEvents();
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
        header('X-Accel-Buffering: no');
        $melbet = new melbet();
        $melbet->getEvents();
    }
    //
    public function actionBet365LeagesParsing()
    {
        header('X-Accel-Buffering: no');
        $bet365 = new bet365();
        $bet365->getLeages();
    }
    //
    public function actionBet365MatchesParsing()
    {
        $bet365 = new bet365();
        $bet365->getMatches();
    }
    //
    public function actionBet365EventsParsing()
    {
        header('X-Accel-Buffering: no');
        $bet365 = new bet365();
        $bet365->getEvents();
    }

}
