<?php
/**
 * Created by PhpStorm.
 * User: luckeri20
 * Date: 17.09.2017
 * Time: 11:38
 */

namespace app\commands;
use yii\console\Controller;
use app\modules\parser\models\marathonbet;
use app\modules\parser\models\sportingbetru;
use app\modules\parser\models\xbet;
use app\modules\parser\models\melbet;
use app\modules\parser\models\leonbets;
use app\modules\parser\models\bet365;
include "/var/www/html/parser/phpQuery.php";

class ParsingController extends Controller
{
    // xbet
    public function actionXbet()
    {
        $child_pid = pcntl_fork();
        if( $child_pid ) {
            exit;
        }
        posix_setsid();
        while (1) {
            try {
                $xbet = new xbet();
                $xbet->getEvents();
                unset($xbet);
                sleep(10);
            } catch (\Exception $e) {
                echo 'exception '.$e->getMessage().PHP_EOL;
            }
        }
    }
    // sportingbet
    public function actionSportingbet()
    {
        $child_pid = pcntl_fork();
        if( $child_pid ) {
            exit;
        }
        posix_setsid();
        while (1) {
            try {
                $sportingbet = new sportingbetru();
                $sportingbet->getEvents();
                unset($sportingbet);
                sleep(10);
            } catch (\Exception $e) {
                echo 'exception '.$e->getMessage().PHP_EOL;
            }
        }
    }
    // leonbets
    public function actionLeonbets()
    {
        $child_pid = pcntl_fork();
        if( $child_pid ) {
            exit;
        }
        posix_setsid();
        while (1) {
            try {
                $leonbets = new leonbets();
                $leonbets->getEvents();
                unset($leonbets);
                sleep(10);
            } catch (\Exception $e) {
                echo 'exception '.$e->getMessage().PHP_EOL;
            }
        }
    }
    // melbet
    public function actionMelbet()
    {
        $child_pid = pcntl_fork();
        if( $child_pid ) {
            exit;
        }
        posix_setsid();
        while (1) {
            try {
                $melbet = new melbet();
                $melbet->getEvents();
                unset($melbet);
                sleep(10);
            } catch (\Exception $e) {
                echo 'exception '.$e->getMessage().PHP_EOL;
            }
        }
    }

    public function actionBet365()
    {
        $bet365 = new bet365();
        $bet365->getLeages();
    }
}