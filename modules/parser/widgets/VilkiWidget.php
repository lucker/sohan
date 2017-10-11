<?php
/**
 * Created by PhpStorm.
 * User: luckeri20
 * Date: 30.09.2017
 * Time: 17:49
 */

namespace app\modules\parser\widgets;

use yii\base\Widget;
use yii\helpers\Html;
class VilkiWidget extends Widget
{
    public function init()
    {
        parent::init();
    }
    public function run()
    {
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
                    m.url,
                    en.name as event_name
            FROM vilki
            LEFT JOIN events e ON e.id = vilki.event_1
            LEFT JOIN matches m ON m.id = e.matches_id
            LEFT JOIN teams t1 ON t1.id = m.team1
            LEFT JOIN teams t2 ON t2.id = m.team2
            LEFT JOIN leages l ON l.id = m.leage
            LEFT JOIN events_name en ON e.name_id = en.id
            LEFT JOIN bukcontor ON bukcontor.id = e.bukid
        ";
        $data1 = \Yii::$app->db
            ->createCommand($sql)
            ->queryAll();
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
                    m.url,
                    en.name as event_name
            FROM vilki
            LEFT JOIN events e ON e.id = vilki.event_2
            LEFT JOIN matches m ON m.id = e.matches_id
            LEFT JOIN teams t1 ON t1.id = m.team1
            LEFT JOIN teams t2 ON t2.id = m.team2
            LEFT JOIN leages l ON l.id = m.leage
            LEFT JOIN events_name en ON e.name_id = en.id
            LEFT JOIN bukcontor ON bukcontor.id = e.bukid
        ";
        $data2 = \Yii::$app->db
            ->createCommand($sql)
            ->queryAll();
        $res = [];
        for ($i=0;$i<count($data1); $i++) {
            $res[] = [
                'date' => $data1[$i]['date'],
                'procent' => round((1 - 1/$data1[$i]['odd'] - 1/$data2[$i]['odd'])*100, 2),
                'parametr' => $data1[$i]['parametr'],
                'data' => [],
            ];
            $res[count($res)-1]['data'][] = [
                'team1' => $data1[$i]['team1'],
                'team2' => $data1[$i]['team2'],
                'leage' => $data1[$i]['name'],
                'bukname' => $data1[$i]['bukname'],
                'odd' => $data1[$i]['odd'],
                'url' => $data1[$i]['url'],
                'update_date' => $data1[$i]['update_date'],
                'event_name' => $data1[$i]['event_name'],
            ];
            $res[count($res)-1]['data'][] = [
                'team1' => $data2[$i]['team1'],
                'team2' => $data2[$i]['team2'],
                'leage' => $data2[$i]['name'],
                'bukname' => $data2[$i]['bukname'],
                'odd' => $data2[$i]['odd'],
                'url' => $data2[$i]['url'],
                'update_date' => $data2[$i]['update_date'],
                'event_name' => $data2[$i]['event_name']
            ];
        }
        return $this->render('vilki', [
            'data' => $res
        ]);
    }
}