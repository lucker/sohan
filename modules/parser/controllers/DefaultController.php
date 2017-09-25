<?php

namespace app\modules\parser\controllers;

use app\modules\parser\models\melbetaqp;
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
    public function actionCheckproxy()
    {
        $proxy = new proxy;
        $proxy->testProxy();
    }
    //
    public function actionTest()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://ru.sportingbeteu358.com/');
        $user_agent = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36';
        $header = [
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
            "Accept-Encoding: gzip",
            "Upgrade-Insecure-Requests: 1",
            "Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4",
            "Connection: keep-alive"
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($ch, CURLOPT_PROXY, '31.31.202.230:1080');
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'luckeri:celopasy');
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $out = curl_exec($ch);
        $info = curl_getinfo($ch);
        echo '<pre>';
        print_r($info);
        echo '</pre>';
        echo $out;
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
        $parsing = \Yii::$app->db
            ->createCommand('
                SELECT `parsing` FROM `bukcontor`
                WHERE `id` = :id', [
                    ':id' => 2
                ])->queryScalar();
        if (!$parsing) {
            $start = microtime(true);
            $marathon = new marathonbet();
            $marathon->getEvents();
            echo 'Время выполнения скрипта(events): ' . (microtime(true) - $start) . ' сек.';
        }
    }
    //
    public function actionXbetLeagesParsing()
    {
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
        $parsing = \Yii::$app->db
            ->createCommand('
                SELECT `parsing` FROM `bukcontor`
                WHERE `id` = :id', [
                ':id' => 1
            ])->queryScalar();
        if (!$parsing) {
            $start = microtime(true);
            $xbet = new xbet();
            $xbet->getEvents();
            echo 'Время выполнения скрипта(events): ' . (microtime(true) - $start) . ' сек.';
        }
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
        header('X-Accel-Buffering: no');
        $start = microtime(true);
        $sportingbet = new Sportingbetru();
        $sportingbet->getMatches();
        echo 'Время выполнения скрипта(events): ' . (microtime(true) - $start) . ' сек.';
    }
    //
    public function actionSportingbetEventsParsing()
    {
        header('X-Accel-Buffering: no');
        $parsing = \Yii::$app->db
            ->createCommand('
                SELECT `parsing` FROM `bukcontor`
                WHERE `id` = :id', [
                ':id' => 3
            ])->queryScalar();
        if (!$parsing) {
            $start = microtime(true);
            $sportingbet = new Sportingbetru();
            $sportingbet->getEvents();
            echo 'Время выполнения скрипта(events): ' . (microtime(true) - $start) . ' сек.';
        }
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
    public function actionMelbetaqpLeagesParsing()
    {
        $melbetaqp = new melbetaqp();
        $melbetaqp->getLeages();
    }
}
