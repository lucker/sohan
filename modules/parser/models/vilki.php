<?php
/**
 * Created by PhpStorm.
 * User: luckeri20
 * Date: 30.09.2017
 * Time: 14:09
 */

namespace app\modules\parser\models;


class vilki extends insertEvents
{
    public function mixed()
    {
        $sql = "
            select count(*) as sum
            from bukcontor
        ";
        $number = $this->getData($sql);

        $array1 = [];
        $array2 = [];
        for ($i=1; $i<=$number[0]['sum']; $i++) {
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
                    en.name as event_name,
                    e.id as eid
                FROM `events` e
                LEFT JOIN matches m ON e.matches_id = m.id AND m.bukid = e.bukid
                LEFT JOIN leages l ON m.leage = l.id AND m.bukid = l.bukid
                LEFT JOIN teams t1 ON t1.id = m.team1
                LEFT JOIN teams t2 ON t2.id = m.team2
                LEFT JOIN bukcontor ON bukcontor.id = e.bukid
                LEFT JOIN events_name en ON e.name_id = en.id AND e.bukid = en.bukid
                WHERE e.bukid = {$i}
                AND m.date> '" . date("Y-m-d H:i:s") . "'
                 AND e.update_date > '".date("Y-m-d")." 00:00:00"."'
                AND t1.group_id is not null
                AND t2.group_id is not null
                AND bukcontor.active = 1
                AND en.group in (6)
            ";
            $res = $this->getData($sql);
            $array1[$i] = $res;
        }

        for ($i=1; $i<=$number[0]['sum']; $i++) {
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
                    en.name as event_name,
                    e.id as eid
                FROM `events` e
                LEFT JOIN matches m ON e.matches_id = m.id AND m.bukid = e.bukid
                LEFT JOIN leages l ON m.leage = l.id AND m.bukid = l.bukid
                LEFT JOIN teams t1 ON t1.id = m.team1
                LEFT JOIN teams t2 ON t2.id = m.team2
                LEFT JOIN bukcontor ON bukcontor.id = e.bukid
                LEFT JOIN events_name en ON e.name_id = en.id AND e.bukid = en.bukid
                WHERE e.bukid = {$i}
                AND m.date> '" . date("Y-m-d H:i:s") . "'
                 AND e.update_date > '".date("Y-m-d")." 00:00:00"."'
                AND t1.group_id is not null
                AND t2.group_id is not null
                AND bukcontor.active = 1
                AND en.group in (3)
            ";
            $res = $this->getData($sql);
            $array2[$i] = $res;
        }
        // сама математика
        for ($k=1; $k<=$number[0]['sum']; $k++) {
            for ($i=0; $i<count($array1[$k]); $i++) {
                for($m=1; $m<=$number[0]['sum']; $m++) {
                    for ($j=0; $j<count($array2[$m]);$j++) {
                        if ($array1[$k][$i]['date']==$array2[$m][$j]['date']&&$array1[$k][$i]['t1group']==$array2[$m][$j]['t1group'] &&
                            $array1[$k][$i]['t2group']==$array2[$m][$j]['t2group']
                        ) {
                            if (1/$array1[$k][$i]['odd'] + 1/$array2[$m][$j]['odd'] <= 1) {
                                $this->insertVilki($array1[$k][$i]['eid'], $array2[$m][$j]['eid']);
                            }
                        }
                    }
                }
            }
        }
    }

    public function mixed2()
    {
        $sql = "
            select count(*) as sum
            from bukcontor
        ";
        $number = $this->getData($sql);

        $array1 = [];
        $array2 = [];
        for ($i=1; $i<=$number[0]['sum']; $i++) {
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
                    en.name as event_name,
                    e.id as eid
                FROM `events` e
                LEFT JOIN matches m ON e.matches_id = m.id AND m.bukid = e.bukid
                LEFT JOIN leages l ON m.leage = l.id AND m.bukid = l.bukid
                LEFT JOIN teams t1 ON t1.id = m.team1
                LEFT JOIN teams t2 ON t2.id = m.team2
                LEFT JOIN bukcontor ON bukcontor.id = e.bukid
                LEFT JOIN events_name en ON e.name_id = en.id AND e.bukid = en.bukid
                WHERE e.bukid = {$i}
                AND m.date> '" . date("Y-m-d H:i:s") . "'
                 AND e.update_date > '".date("Y-m-d")." 00:00:00"."'
                AND t1.group_id is not null
                AND t2.group_id is not null
                AND bukcontor.active = 1
                AND en.group in (7)
            ";
            $res = $this->getData($sql);
            $array1[$i] = $res;
        }

        for ($i=1; $i<=$number[0]['sum']; $i++) {
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
                    en.name as event_name,
                    e.id as eid
                FROM `events` e
                LEFT JOIN matches m ON e.matches_id = m.id AND m.bukid = e.bukid
                LEFT JOIN leages l ON m.leage = l.id AND m.bukid = l.bukid
                LEFT JOIN teams t1 ON t1.id = m.team1
                LEFT JOIN teams t2 ON t2.id = m.team2
                LEFT JOIN bukcontor ON bukcontor.id = e.bukid
                LEFT JOIN events_name en ON e.name_id = en.id AND e.bukid = en.bukid
                WHERE e.bukid = {$i}
                AND m.date> '" . date("Y-m-d H:i:s") . "'
                 AND e.update_date > '".date("Y-m-d")." 00:00:00"."'
                AND t1.group_id is not null
                AND t2.group_id is not null
                AND bukcontor.active = 1
                AND en.group in (1)
            ";
            $res = $this->getData($sql);
            $array2[$i] = $res;
        }
        // сама математика
        for ($k=1; $k<=$number[0]['sum']; $k++) {
            for ($i=0; $i<count($array1[$k]); $i++) {
                for($m=1; $m<=$number[0]['sum']; $m++) {
                    for ($j=0; $j<count($array2[$m]);$j++) {
                        if ($array1[$k][$i]['date']==$array2[$m][$j]['date']&&$array1[$k][$i]['t1group']==$array2[$m][$j]['t1group'] &&
                            $array1[$k][$i]['t2group']==$array2[$m][$j]['t2group']
                        ) {
                            if (1/$array1[$k][$i]['odd'] + 1/$array2[$m][$j]['odd'] <= 1) {
                                $this->insertVilki($array1[$k][$i]['eid'], $array2[$m][$j]['eid']);
                            }
                        }
                    }
                }
            }
        }
    }

    public function mixed3()
    {
        $sql = "
            select count(*) as sum
            from bukcontor
        ";
        $number = $this->getData($sql);

        $array1 = [];
        $array2 = [];
        for ($i=1; $i<=$number[0]['sum']; $i++) {
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
                    en.name as event_name,
                    e.id as eid
                FROM `events` e
                LEFT JOIN matches m ON e.matches_id = m.id AND m.bukid = e.bukid
                LEFT JOIN leages l ON m.leage = l.id AND m.bukid = l.bukid
                LEFT JOIN teams t1 ON t1.id = m.team1
                LEFT JOIN teams t2 ON t2.id = m.team2
                LEFT JOIN bukcontor ON bukcontor.id = e.bukid
                LEFT JOIN events_name en ON e.name_id = en.id AND e.bukid = en.bukid
                WHERE e.bukid = {$i}
                AND m.date> '" . date("Y-m-d H:i:s") . "'
                 AND e.update_date > '".date("Y-m-d")." 00:00:00"."'
                AND t1.group_id is not null
                AND t2.group_id is not null
                AND bukcontor.active = 1
                AND en.group in (8)
            ";
            $res = $this->getData($sql);
            $array1[$i] = $res;
        }

        for ($i=1; $i<=$number[0]['sum']; $i++) {
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
                    en.name as event_name,
                    e.id as eid
                FROM `events` e
                LEFT JOIN matches m ON e.matches_id = m.id AND m.bukid = e.bukid
                LEFT JOIN leages l ON m.leage = l.id AND m.bukid = l.bukid
                LEFT JOIN teams t1 ON t1.id = m.team1
                LEFT JOIN teams t2 ON t2.id = m.team2
                LEFT JOIN bukcontor ON bukcontor.id = e.bukid
                LEFT JOIN events_name en ON e.name_id = en.id AND e.bukid = en.bukid
                WHERE e.bukid = {$i}
                AND m.date> '" . date("Y-m-d H:i:s") . "'
                 AND e.update_date > '".date("Y-m-d")." 00:00:00"."'
                AND t1.group_id is not null
                AND t2.group_id is not null
                AND bukcontor.active = 1
                AND en.group in (2)
            ";
            $res = $this->getData($sql);
            $array2[$i] = $res;
        }
        // сама математика
        for ($k=1; $k<=$number[0]['sum']; $k++) {
            for ($i=0; $i<count($array1[$k]); $i++) {
                for($m=1; $m<=$number[0]['sum']; $m++) {
                    for ($j=0; $j<count($array2[$m]);$j++) {
                        if ($array1[$k][$i]['date']==$array2[$m][$j]['date']&&$array1[$k][$i]['t1group']==$array2[$m][$j]['t1group'] &&
                            $array1[$k][$i]['t2group']==$array2[$m][$j]['t2group']
                        ) {
                            if (1/$array1[$k][$i]['odd'] + 1/$array2[$m][$j]['odd'] <= 1) {
                                $this->insertVilki($array1[$k][$i]['eid'], $array2[$m][$j]['eid']);
                            }
                        }
                    }
                }
            }
        }
    }

    public function totals()
    {
        $sql = "
            select count(*) as sum
            from bukcontor
        ";
        $number = $this->getData($sql);
        //сама логика
        $tbArray = [];
        for ($i=1; $i<=$number[0]['sum']; $i++) {
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
                    en.name as event_name,
                    e.id as eid
                FROM `events` e
                LEFT JOIN matches m ON e.matches_id = m.id AND m.bukid = e.bukid
                LEFT JOIN leages l ON m.leage = l.id AND m.bukid = l.bukid
                LEFT JOIN teams t1 ON t1.id = m.team1
                LEFT JOIN teams t2 ON t2.id = m.team2
                LEFT JOIN bukcontor ON bukcontor.id = e.bukid
                LEFT JOIN events_name en ON e.name_id = en.id AND e.bukid = en.bukid
                WHERE e.bukid = {$i}
                AND m.date> '" . date("Y-m-d H:i:s") . "'
                 AND e.update_date > '".date("Y-m-d")." 00:00:00"."'
                AND t1.group_id is not null
                AND t2.group_id is not null
                AND bukcontor.active = 1
                AND en.group in (4)
            ";
            $res = $this->getData($sql);
            $array1[$i] = $res;
        }
        $tmArray = [];
        for ($i=1; $i<=$number[0]['sum']; $i++) {
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
                    en.name as event_name,
                    e.id as eid
                FROM `events` e
                LEFT JOIN matches m ON e.matches_id = m.id AND m.bukid = e.bukid
                LEFT JOIN leages l ON m.leage = l.id AND m.bukid = l.bukid
                LEFT JOIN teams t1 ON t1.id = m.team1
                LEFT JOIN teams t2 ON t2.id = m.team2
                LEFT JOIN bukcontor ON bukcontor.id = e.bukid
                LEFT JOIN events_name en ON e.name_id = en.id AND e.bukid = en.bukid
                WHERE e.bukid = {$i}
                AND m.date> '" . date("Y-m-d H:i:s") . "'
                AND e.update_date > '".date("Y-m-d")." 00:00:00"."'
                AND t1.group_id is not null
                AND t2.group_id is not null
                AND bukcontor.active = 1
                AND en.group in (5)
            ";
            $res = $this->getData($sql);
            $array2[$i] = $res;
        }
        $res = [];
        for ($i=1; $i<=$number[0]['sum']; $i++) {
            for ($j=0; $j<count($array1[$i]); $j++) {
                for ($k=1; $k<=$number[0]['sum']; $k++) {
                    for ($m=0; $m<count($array2[$k]); $m++) {
                        if (
                            $array1[$i][$j]['t1group'] == $array2[$k][$m]['t1group'] && $array1[$i][$j]['t2group'] == $array2[$k][$m]['t2group']
                            && $array1[$i][$j]['date'] == $array2[$k][$m]['date'] && $array1[$i][$j]['parametr'] == $array2[$k][$m]['parametr']) {
                            if ( 1/$array1[$i][$j]['odd'] +1/$array2[$k][$m]['odd'] <= 1) {
                                $this->insertVilki($array1[$i][$j]['eid'], $array2[$k][$m]['eid']);
                            }
                        }
                    }
                }
            }
        }
    }

    public function checkOldVilki() {
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
                    en.name as event_name,
                    vilki.id as vilki_id
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
                    en.name as event_name,
                    vilki.id as vilki_id
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

        for ($i=0;$i<count($data1); $i++) {
            $procent = round((1 - 1/$data1[$i]['odd'] - 1/$data2[$i]['odd'])*100, 2);
            if ($procent<0) {
                $sql = "
                    DELETE FROM `vilki` WHERE `id` = {$data1[$i]['vilki_id']}
                ";
                $this->mysqli->query($sql);
            }
            if ($data1[$i]['date']<date("Y-m-d H:i:s")) {
                $sql = "
                    DELETE FROM `vilki` WHERE `id` = {$data1[$i]['vilki_id']}
                ";
                $this->mysqli->query($sql);
            }
        }


    }
}