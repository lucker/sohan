<?php
namespace app\modules\parser\controllers;

use yii\web\Controller;
/**
 * Created by PhpStorm.
 * User: luckeri20
 * Date: 28.06.2017
 * Time: 19:41
 */
class TestController extends Controller
{
    public function actionTest()
    {
        $v8 = new \V8Js();
    }
    public function actionShow()
    {
        $sql = "
                            SELECT
                    t1.name as team1,
                    t2.name as team2,
                    l.name as leage,
                    m.date,
                    -- en.group as name_id,
                    en.name,
                    e.odd,
                    e.parametr,
                    -- e.bukid,
                    -- t1.group_id as t1group,
                    -- t2.group_id as t2group,
                    bukcontor.name as bukname,
                    e.inserted_date
                FROM sohan.`events` e
                INNER JOIN sohan.matches m ON e.matches_id = m.id AND m.bukid = e.bukid
                LEFT JOIN sohan.leages l ON m.leage = l.id  AND m.bukid = l.bukid
                LEFT JOIN sohan.teams t1 ON t1.id = m.team1
                LEFT JOIN sohan.teams t2 ON t2.id = m.team2
                LEFT JOIN sohan.bukcontor ON bukcontor.id = e.bukid
                LEFT JOIN sohan.events_name en ON e.name_id = en.id AND e.bukid = en.bukid
        ";
    }
}