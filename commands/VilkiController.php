<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\modules\parser\models\vilki;

class VilkiController extends Controller
{
    public function actionVilki()
    {
        $child_pid = pcntl_fork();
        if( $child_pid ) {
            exit;
        }
        posix_setsid();
        $vilki = new vilki();
        while (1) {
            $vilki->mixed();
            $vilki->mixed2();
            $vilki->mixed3();
            $vilki->totals();
            $vilki->checkOldVilki();
            sleep(20);
        }
        $vilki = new vilki();
    }
}