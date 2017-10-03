<?php
/**
 * Created by PhpStorm.
 * User: Manager
 * Date: 29.09.2017
 * Time: 13:15
 */

namespace app\modules\parser\models;

class insertEvents
{
    protected $mysqli;

    function __construct() {
        $this->mysqli = new \mysqli('127.0.0.1', 'root', '1q2w3e4r5t', 'sohan');
        $this->mysqli->set_charset("utf8");
        date_default_timezone_set('Etc/GMT-3');
    }

    function __destruct() {
        $this->mysqli->close();
    }

    function getData($sql) {
        $result = $this->mysqli->query($sql);
        if (!$result) {
            return false;
        }
        $res = [];
        while ($data = $result->fetch_assoc()) {
            $res[] = $data;
        }
        $result->close();
        //$result->free();
        return $res;
    }
    // insert team
    public function insertTeam($teams) {
        $id = [];
        $selectedId = $this->getData(
            "SELECT id FROM `teams` WHERE `name` = '{$teams[0]}'"
        );
        if (empty($selectedId[0]['id'])) {
            $sql = "INSERT INTO  `teams` (`id` ,`name`) VALUES (NULL , '{$teams[0]}')";
            $this->mysqli->query($sql);
            $id[] = $this->mysqli->insert_id;
        } else {
            $id[] = $selectedId[0]['id'];
        }
        $selectedId = $this->getData(
            "SELECT id FROM `teams` WHERE `name` = '{$teams[1]}'"
        );
        if (empty($selectedId[0]['id'])) {
            $sql = "INSERT INTO  `teams` (`id` ,`name`) VALUES (NULL , '{$teams[1]}')";
            $this->mysqli->query($sql);
            $id[] = $this->mysqli->insert_id;
        } else {
            $id[] = $selectedId[0]['id'];
        }
        return $id;
    }
    // insert matches
    public function insertMatch($teamIds, $leage, $date, $bukid, $url, $parsingUrl) {
        $id = 0;
        $data = $this->getData("
            SELECT 
                id, 
                url, 
                parsing_url,
                leage
            FROM matches
            WHERE `team1` = {$teamIds[0]}
            AND `team2` = {$teamIds[1]}
            AND `bukid` = {$bukid}
            AND `date` = '{$date}'");
        if (!$data) {
            $this->mysqli->query("INSERT INTO matches (`id`, `team1`, `team2`, `leage`, `date`, `bukid`, `inserted_date`, `url`, `parsing_url`)
                VALUES (NULL, {$teamIds[0]}, {$teamIds[1]}, {$leage}, '{$date}', {$bukid}, '".date('Y-m-d H:i:s')."', '{$url}', '{$parsingUrl}')");
            $id = $this->mysqli->insert_id;
        } else {
            $id = $data[0]['id'];
            // проверяем урл изменился ли
            if ($url != $data[0]['url']) {
                $sql = "
                    UPDATE `matches` 
                    SET `url`='{$url}'
                    WHERE `id`={$id}
                ";
                $this->mysqli->query($sql);
            }
            // проверяем изменилась ли лига
            if ($leage != $data[0]['leage']) {
                $sql = "
                    UPDATE `matches` 
                    SET `leage`='{$leage}'
                    WHERE `id`={$id}
                ";
                $this->mysqli->query($sql);
            }
            // проверяем изменился ли урл для парсинга
            if ($parsingUrl != $data[0]['parsing_url']) {
                $sql = "
                    UPDATE `matches` 
                    SET `parsing_url`='{$parsingUrl}'
                    WHERE `id`={$id}
                ";
                $this->mysqli->query($sql);
            }
        }
        return $id;
    }
    // insert leages
    public function insertLeage($name, $bukid, $parsingUrl) {
        $leageId = 0;
        $data = $this->getData(
            "SELECT id, parsing_url 
            FROM `leages`
            WHERE `name` = '{$name}'
            AND `bukid` = {$bukid}"
        );
        // запись лиги
        if (!$data) {
            $this->mysqli->query("INSERT INTO  `leages` (`id`, `name`, `bukid`, `parsing_url`)
                    VALUES (NULL , '{$name}',  {$bukid}, '{$parsingUrl}')");
            $leageId = $this->mysqli->insert_id;
        } else {
            $leageId = $data[0]['id'];
            if ($parsingUrl!=$data[0]['parsing_url']) {
                $sql = "
                    UPDATE `leages` 
                    SET `parsing_url` = '{$parsingUrl}'
                    WHERE `id` = {$leageId}
                ";
                $this->mysqli->query($sql);
            }
        }
        return $leageId;
    }
    // insert events
    public function insertEvents($matchId, $parametr, $nameId, $odd, $bukid) {
        $eventId = 0;
        if ($parametr) {
            $data = $this->getData("
                SELECT id, odd FROM `events` 
                WHERE `matches_id` = {$matchId}
                AND `name_id` = {$nameId}
                AND `parametr` = {$parametr}
                AND `bukid` = {$bukid}
            ");
        } else {
            $data = $this->getData("
                SELECT id, odd FROM `events` 
                WHERE `matches_id` = {$matchId}
                AND `name_id` = {$nameId}
                AND `bukid` = {$bukid}
            ");
        }
        if (!$data) {
            if (!$parametr) {
                $sql = "
                    INSERT INTO `events` (`matches_id`, `name_id`, `parametr`, `odd`, `bukid`, `update_date`, `inserted_date`)
                    VALUES ({$matchId}, {$nameId}, null, {$odd}, {$bukid},'".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')
                ";
            } else {
                $sql = "
                    INSERT INTO `events` (`matches_id`, `name_id`, `parametr`, `odd`, `bukid`, `update_date`, `inserted_date`)
                    VALUES ({$matchId}, {$nameId}, {$parametr}, {$odd}, {$bukid}, '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')
                ";
            }
            $this->mysqli->query($sql);
            $eventId = $this->mysqli->insert_id;
        } else {
            $eventId = $data[0]['id'];
            //update value если не совпадают значения
            if ($data[0]['odd']!=$odd) {
                $sql = "
                    UPDATE `events` 
                    SET `odd`={$odd}, `update_date`='".date('Y-m-d H:i:s')."'
                    WHERE (`id`={$eventId})
                ";
                $this->mysqli->query($sql);
            } else {
                //совпадают обновляем время получение информации
                $sql = "
                    UPDATE `events` 
                    SET `update_date`='".date('Y-m-d H:i:s')."'
                    WHERE (`id`={$eventId})
                ";
                $this->mysqli->query($sql);
            }
        }
        return $eventId;
    }
    // insert event name
    public function insertEventName($name, $bukid, $group_id) {
        $eventNameId = 0;
        $data = $this->getData("
            SELECT id FROM  `events_name`
            WHERE `name` = '{$name}'
            AND bukid = {$bukid}
        ");
        if (!$data) {
            $sql = "
                INSERT INTO `events_name` (`id`, `name`, `bukid`) 
                VALUES (NULL, '{$name}', {$bukid})
            ";
            $this->mysqli->query($sql);
            $eventNameId = $this->mysqli->insert_id;
        } else {
            $eventNameId = $data[0]['id'];
        }
        return $eventNameId;
    }
    // insert vilki
    public function insertVilki($eventId1, $eventId2)
    {
        $vilkiId = -1;
        $data = $this->getData("
            SELECT * 
            FROM vilki
            WHERE event_1 = {$eventId1}
            AND event_2 = {$eventId2}
        ");
        if (!$data) {
            $sql = "
                INSERT INTO `vilki` (`id`, `event_1`, `event_2`, `inserted_date`) 
                VALUES (NULL, '{$eventId1}', {$eventId2}, '".date('Y-m-d H:i:s')."')
            ";
            $this->mysqli->query($sql);
            $vilkiId = $this->mysqli->insert_id;
        } else {
            $vilkiId = $data[0]['id'];
        }
        return $vilkiId;
    }
}