<?php
namespace app\modules\parser\widgets;

use yii\base\Widget;
use yii\helpers\Html;
class WinsWidget extends Widget
{
    public $winsArray;
    public function init()
    {
        parent::init();
        //сама логика
        $resArray = [];

        for ($i=1; $i<=3; $i++) {
            $sql = "
                SELECT
                    t1.name as team1,
                    t2.name as team2,
                    m.date,
                    en.group as name_id,
                    e.odd,
                    l.name,
                    e.bukid,
                    t1.group_id as t1group,
                    t2.group_id as t2group,
                    bukcontor.name as bukname,
                    e.update_date,
                    m.url
                FROM sohan.`events` e
                INNER JOIN sohan.matches m ON e.matches_id = m.id AND m.bukid = e.bukid
                LEFT JOIN sohan.leages l ON m.leage = l.id  AND m.bukid = l.bukid
                LEFT JOIN sohan.teams t1 ON t1.id = m.team1
                LEFT JOIN sohan.teams t2 ON t2.id = m.team2
                LEFT JOIN sohan.bukcontor ON bukcontor.id = e.bukid
                LEFT JOIN sohan.events_name en ON e.name_id = en.id AND e.bukid = en.bukid
                WHERE e.bukid = {$i}
                AND m.date> '" . date("Y-m-d H:i:s") . "'
                AND t1.group_id is not null
                AND t2.group_id is not null
                AND bukcontor.active = 1
                AND en.group in (1,2,3)
            ";
            $res = \Yii::$app->db
                ->createCommand($sql)
                ->queryAll();
            $resArray[$i] = $res;
        }
        /*
        echo '<pre>';
        print_r($resArray);
        echo '</pre>';
        exit;
        */
        $odds = [];
        $team1 = '';
        $i = 1;
        //for ($i=1; $i<=3; $i++) {
        for ($j=0; $j<count($resArray[$i]); $j=$j+3) {
            $currentOdds = [];
            for ($k=1; $k<=3; $k++) {
                for($m=0; $m<count($resArray[$k]); $m=$m+3) {
                    //совпадение команд в другой конторе
                    if ($resArray[$i][$j]['t1group'] == $resArray[$k][$m]['t1group'] && $resArray[$i][$j]['t2group'] == $resArray[$k][$m]['t2group']
                        && $resArray[$i][$j]['date'] == $resArray[$k][$m]['date']) {
                        for ($nameId=0; $nameId<3; $nameId++) {
                            $currentOdds[$nameId + 1][] = [
                                'odd' => $resArray[$k][$m+$nameId]['odd'],
                                'team1' => $resArray[$k][$m+$nameId]['team1'],
                                'team2' => $resArray[$k][$m+$nameId]['team2'],
                                'bukname' => $resArray[$k][$m+$nameId]['bukname'],
                                'date' => $resArray[$k][$m+$nameId]['date'],
                                'leage' => $resArray[$k][$m+$nameId]['name'],
                                'update_date' => $resArray[$k][$m+$nameId]['update_date'],
                                'url' => $resArray[$k][$m+$nameId]['url']
                            ];
                        }
                    }
                }
            }
            $odds[] = $currentOdds;
        }
        //}
        /*echo '<pre>';
        print_r($odds);
        echo '</pre>';
        exit;*/
        //
        $res = [];
        for($i=0; $i<count($odds); $i++) {
            //находим максимальные элементы
            $maxArray = [];
            for($nameId=1; $nameId<=3; $nameId++) {
                $maxId = 0;
                if (isset($odds[$i][$nameId][$maxId]['odd'])) {
                    $max = $odds[$i][$nameId][$maxId]['odd'];
                    for ($j = 0; $j < count($odds[$i][$nameId]); $j++) {
                        if ($odds[$i][$nameId][$j]['odd'] > $max) {
                            $max = $odds[$i][$nameId][$j]['odd'];
                            $maxId = $j;
                        }
                    }

                    $maxArray[$nameId] = [
                        'id' => $maxId,
                        'team1' => $odds[$i][$nameId][$maxId]['team1'],
                        'team2' => $odds[$i][$nameId][$maxId]['team2'],
                        'bukname' => $odds[$i][$nameId][$maxId]['bukname'],
                        'date' => $odds[$i][$nameId][$maxId]['date'],
                        'odd' => $odds[$i][$nameId][$maxId]['odd'],
                        'leage' => $odds[$i][$nameId][$maxId]['leage'],
                        'update_date' => $odds[$i][$nameId][$maxId]['update_date'],
                        'url' => $odds[$i][$nameId][$maxId]['url']
                    ];
                }
            }
            if (isset($maxArray[1]['odd'])&&isset($maxArray[2]['odd'])&&isset($maxArray[3]['odd'])) {
                if (1 / $maxArray[1]['odd'] + 1 / $maxArray[2]['odd'] + 1 / $maxArray[3]['odd'] <= 1) {
                    $res[] = [
                        'data' => $maxArray,
                        'date' => $maxArray[1]['date'],
                        'procent' => round((1 - 1 / $maxArray[1]['odd'] - 1 / $maxArray[2]['odd'] - 1 / $maxArray[3]['odd']) * 100, 2)
                    ];
                }
            }
        }
        $this->winsArray = $res;
    }

    public function run()
    {
        return $this->render('wins', [
            'data' => $this->winsArray
        ]);
    }
}