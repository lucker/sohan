<?php
/**
 * Created by PhpStorm.
 * User: Manager
 * Date: 16.08.2017
 * Time: 12:15
 */

namespace app\modules\parser\controllers;

use yii\web\Controller;
class TempController
{
    /**
     * Темповую таблицу в обычную
     */
    public function actionTempintoprod()
    {
        // events копирование с темп
        $sql = "
            INSERT INTO `sohan`.`events`
            SELECT *
            FROM `temp`.`events`
        ";
        Yii::$app->db->createCommand($sql);
        $sql = "TRUNCATE TABLE temp.events";
        Yii::$app->db->createCommand($sql);
        // matches копирование с темп
        $sql = "
            INSERT INTO `sohan`.`matches`
            SELECT *
            FROM `temp`.`matches`
        ";
        Yii::$app->db->createCommand($sql);
        $sql = "TRUNCATE TABLE temp.matches";
        Yii::$app->db->createCommand($sql);

    }
}