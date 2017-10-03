<?php
/**
 * Created by PhpStorm.
 * User: Manager
 * Date: 28.07.2017
 * Time: 17:16
 */

namespace app\modules\parser\widgets;

use yii\base\Widget;
use yii\helpers\Html;
class TotalsWidget extends Widget
{
    public $totals;
    public function init()
    {
        parent::init();
        // time zone
        date_default_timezone_set('Etc/GMT-3');
        //сама логика
        $tbArray = [];
        for ($i=1; $i<=5; $i++) {
            $sql = "
                SELECT
                    t1.name as team1,
                    t2.name as team2,
                    m.date,
                    en.group as name_id,
                    e.odd,
                    e.parametr,
                    l.name,
                    e.bukid,
                    t1.group_id as t1group,
                    t2.group_id as t2group,
                    bukcontor.name as bukname,
                    e.update_date,
                    m.url
                FROM `events` e
                LEFT JOIN matches m ON e.matches_id = m.id AND m.bukid = e.bukid
                LEFT JOIN leages l ON m.leage = l.id AND m.bukid = l.bukid
                LEFT JOIN teams t1 ON t1.id = m.team1
                LEFT JOIN teams t2 ON t2.id = m.team2
                LEFT JOIN bukcontor ON bukcontor.id = e.bukid
                LEFT JOIN events_name en ON e.name_id = en.id AND e.bukid = en.bukid
                WHERE e.bukid = {$i}
                AND m.date> '" . date("Y-m-d H:i:s") . "'
                AND t1.group_id is not null
                AND t2.group_id is not null
                AND bukcontor.active = 1
                AND en.group in (4)
            ";
            $res = \Yii::$app->db
                ->createCommand($sql)
                ->queryAll();
            $tbArray[$i] = $res;
        }
        $tmArray = [];
        for ($i=1; $i<=5; $i++) {
            $sql = "
                SELECT
                    t1.name as team1,
                    t2.name as team2,
                    m.date,
                    en.group as name_id,
                    e.odd,
                    e.parametr,
                    l.name,
                    e.bukid,
                    t1.group_id as t1group,
                    t2.group_id as t2group,
                    bukcontor.name as bukname,
                    e.update_date,
                    m.url
                FROM `events` e
                LEFT JOIN matches m ON e.matches_id = m.id AND m.bukid = e.bukid
                LEFT JOIN leages l ON m.leage = l.id AND m.bukid = l.bukid
                LEFT JOIN teams t1 ON t1.id = m.team1
                LEFT JOIN teams t2 ON t2.id = m.team2
                LEFT JOIN bukcontor ON bukcontor.id = e.bukid
                LEFT JOIN events_name en ON e.name_id = en.id AND e.bukid = en.bukid
                WHERE e.bukid = {$i}
                AND m.date> '" . date("Y-m-d H:i:s") . "'
                AND t1.group_id is not null
                AND t2.group_id is not null
                AND bukcontor.active = 1
                AND en.group in (5)
            ";
            $res = \Yii::$app->db
                ->createCommand($sql)
                ->queryAll();
            $tmArray[$i] = $res;
        }

        $res = [];
        for ($i=1; $i<=5; $i++) {
            for ($j=0; $j<count($tbArray[$i]); $j++) {
                for ($k=1; $k<=5; $k++) {
                    for ($m=0; $m<count($tmArray[$k]); $m++) {
                        //similar_text($tbArray[$i][$j]['team1'], $tmArray[$k][$m]['team1'], $percent1);
                        //similar_text($tbArray[$i][$j]['team2'], $tmArray[$k][$m]['team2'], $percent2);
                        if (
                            $tbArray[$i][$j]['t1group'] == $tmArray[$k][$m]['t1group'] && $tbArray[$i][$j]['t2group'] == $tmArray[$k][$m]['t2group']
                            //$percent1 > 70 && $percent2 > 70
                        && $tbArray[$i][$j]['date'] == $tmArray[$k][$m]['date'] && $tbArray[$i][$j]['parametr'] == $tmArray[$k][$m]['parametr']) {
                            if ( 1/$tbArray[$i][$j]['odd'] +1/$tmArray[$k][$m]['odd'] <= 1) {
                                $res[] = [
                                    'date' => $tbArray[$i][$j]['date'],
                                    'parametr' => $tbArray[$i][$j]['parametr'],
                                    'procent' => round((1 - 1/$tbArray[$i][$j]['odd'] - 1/$tmArray[$k][$m]['odd'])*100, 2),
                                    'data' => [],
                                ];
                                $res[count($res)-1]['data'][] = [
                                    'team1' => $tbArray[$i][$j]['team1'],
                                    'team2' => $tbArray[$i][$j]['team2'],
                                    'leage' => $tbArray[$i][$j]['name'],
                                    'bukname' => $tbArray[$i][$j]['bukname'],
                                    'odd' => $tbArray[$i][$j]['odd'],
                                    'url' => $tbArray[$i][$j]['url'],
                                    'update_date' => $tbArray[$i][$j]['update_date']
                                ];
                                $res[count($res)-1]['data'][] = [
                                    'team1' => $tmArray[$k][$m]['team1'],
                                    'team2' => $tmArray[$k][$m]['team2'],
                                    'leage' => $tmArray[$k][$m]['name'],
                                    'bukname' => $tmArray[$k][$m]['bukname'],
                                    'odd' => $tmArray[$k][$m]['odd'],
                                    'url' => $tmArray[$k][$m]['url'],
                                    'update_date' => $tmArray[$k][$m]['update_date']
                                ];
                            }
                        }
                    }
                }
            }
        }
        /*echo '<pre>';
        print_r($res);
        echo '</pre>';*/
        $this->totals = $res;

    }
    public function run()
    {
        return $this->render('totals', [
            'data' => $this->totals
        ]);
    }
}