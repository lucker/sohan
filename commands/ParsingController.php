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
        $xbet = new xbet();
        while (1) {
            $xbet->getEvents();
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
        $sportingbet = new sportingbetru();
        while (1) {
            $sportingbet->getEvents();
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
        $leonbets = new leonbets();
        while (1) {
            $leonbets->getEvents();
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
        $melbet = new melbet();
        while (1) {
            $melbet->getEvents();
        }
    }
}