<?php
/**
 * Created by PhpStorm.
 * User: Manager
 * Date: 03.07.2017
 * Time: 16:30
 */

namespace app\modules\parser\models;

use Yii;

class insertEventsModel
{
    //insert teams
    public function insertTeam($teams)
    {
        $id = [];
        $selectedId = Yii::$app->db
            ->createCommand('
                SELECT id FROM `teams` WHERE `name` = :name', [
                ':name' => $teams[0],
            ])->queryScalar();
        if (empty($selectedId)) {
            Yii::$app->db
                ->createCommand('
                    INSERT INTO  `teams` (`id` ,`name`)
                    VALUES (NULL ,  :name)', [
                    ':name' => $teams[0],
                ])->execute();
            $id[] = Yii::$app->db
                ->getLastInsertID();
        } else {
            $id[] = $selectedId;
        }
        //
        $selectedId = Yii::$app->db
            ->createCommand('
                SELECT id FROM `teams` WHERE `name` = :name', [
                ':name' => $teams[1],
            ])->queryScalar();
        if (empty($selectedId)) {
            Yii::$app->db
                ->createCommand('
                    INSERT INTO `teams` (`id` ,`name` )
                    VALUES (NULL ,  :name )', [
                    ':name' => $teams[1],
                ])->execute();
            $id[] = Yii::$app->db
                ->getLastInsertID();
        } else {
            $id[] = $selectedId;
        }
        return $id;
    }
    //insert matches
    public function insertMatch($teamIds, $leage, $date, $bukid, $url)
    {
        $selected = Yii::$app->db
            ->createCommand('
                SELECT id FROM matches
                WHERE `team1` = :team1
                AND `team2` = :team2
                AND `bukid` = :bukid
                AND `date` = :date', [
                    ':team1' => $teamIds[0],
                    ':team2' => $teamIds[1],
                    ':date' => $date,
                    ':bukid' => $bukid
            ])->queryScalar();
        $id = $selected;
        if (!$selected) {
            Yii::$app->db
                ->createCommand("
                    INSERT INTO matches (`id`, `team1`, `team2`, `leage`, `date`, `bukid`, `inserted_date`, `url`)
                    VALUES (NULL, :team1, :team2, :leage, :date, :bukid, :insert_date, :url)", [
                        ':team1' => $teamIds[0],
                        ':team2' => $teamIds[1],
                        ':leage' => $leage,
                        ':date' => $date,
                        ':bukid' => $bukid,
                        ':insert_date' => date('Y-m-d H:i:s'),
                        ':url' => $url
                ])->execute();
            $id = Yii::$app->db
                ->getLastInsertID();
        } else {
            // проверяем урл изменился ли
            $urlSelected = Yii::$app->db
                ->createCommand('
                SELECT url FROM matches
                WHERE `team1` = :team1
                AND `team2` = :team2
                AND `bukid` = :bukid
                AND `date` = :date', [
                    ':team1' => $teamIds[0],
                    ':team2' => $teamIds[1],
                    ':date' => $date,
                    ':bukid' => $bukid
                ])->queryScalar();
            if ($url != $urlSelected) {
                $sql = "
                    UPDATE `matches` 
                    SET `url`='{$url}'
                    WHERE `id`={$selected}
                ";
                Yii::$app->db
                    ->createCommand($sql)
                    ->execute();
            }
            // проверяем изменилась ли лига
            $leageSelected = Yii::$app->db
                ->createCommand('
                SELECT leage FROM matches
                WHERE `team1` = :team1
                AND `team2` = :team2
                AND `bukid` = :bukid
                AND `date` = :date', [
                    ':team1' => $teamIds[0],
                    ':team2' => $teamIds[1],
                    ':date' => $date,
                    ':bukid' => $bukid
                ])->queryScalar();
            if ($leage != $leageSelected) {
                $sql = "
                    UPDATE `matches` 
                    SET `leage`='{$leage}'
                    WHERE `id`={$selected}
                ";
                Yii::$app->db
                    ->createCommand($sql)
                    ->execute();
            }
        }
        return $id;
    }
    //insert leages
    public function insertLeage($name, $bukid)
    {
        $leageId = 0;
        $haveLeages = Yii::$app->db
            ->createCommand('
                    SELECT id FROM `leages` 
                    WHERE `name` = :name AND `bukid` = :bukid', [
                ':name' => $name,
                ':bukid' => $bukid
            ])->queryScalar();
        //запись лиги
        if(!$haveLeages) {
            Yii::$app->db
                ->createCommand('
                    INSERT INTO  `leages` (`id` ,`name` ,`bukid`)
                    VALUES (NULL ,  :name,  :bukid);', [
                    ':name' => $name,
                    ':bukid' => $bukid
                ])->execute();
            $leageId = Yii::$app->db
                ->getLastInsertID();
        } else {
            $leageId = $haveLeages;
        }
        return $leageId;
    }
    //insert events
    public function insertEvents($matchId, $parametr, $nameId, $odd, $bukid)
    {
        if($parametr) {
            $eventId = Yii::$app->db
                ->createCommand('
                    SELECT id FROM `events` 
                    WHERE `matches_id` = :matches_id 
                    AND `name_id` = :name_id
                    AND `parametr` = :parametr
                    AND `bukid` = :bukid', [
                    ':matches_id' => $matchId,
                    ':name_id' => $nameId,
                    ':bukid' => $bukid,
                    ':parametr' => $parametr
                ])->queryScalar();
        } else {
            $eventId = Yii::$app->db
                ->createCommand('
                    SELECT id FROM `events` 
                    WHERE `matches_id` = :matches_id 
                    AND `name_id` = :name_id
                    AND `bukid` = :bukid', [
                    ':matches_id' => $matchId,
                    ':name_id' => $nameId,
                    ':bukid' => $bukid
                ])->queryScalar();
        }
        if (!$eventId) {
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
            Yii::$app->db
                ->createCommand($sql)
                ->execute();
            $eventId = Yii::$app->db
                ->getLastInsertID();
        } else {
            //update value если не совпадают значения
            $sql = "
                SELECT odd FROM `events`
                WHERE `id` = {$eventId}
            ";
            $eventOdd = Yii::$app->db
                ->createCommand($sql)
                ->queryScalar();
            if ($eventOdd!=$odd) {
                $sql = "
                    UPDATE `events` 
                    SET `odd`={$odd}, `update_date`='".date('Y-m-d H:i:s')."'
                    WHERE (`id`={$eventId})
                ";
                Yii::$app->db
                    ->createCommand($sql)
                    ->execute();
            } else {
                //совпадают обновляем время получение информации
                $sql = "
                    UPDATE `events` 
                    SET `update_date`='".date('Y-m-d H:i:s')."'
                    WHERE (`id`={$eventId})
                ";
                Yii::$app->db
                    ->createCommand($sql)
                    ->execute();
            }
        }
        return $eventId;
    }
    // insert event name
    public function insertEventName($name, $bukid, $group_id)
    {
        if ($group_id) {
            $selected = Yii::$app->db
                ->createCommand('
                SELECT id FROM  `events_name`
                WHERE `name` = :name
                AND bukid = :bukid
                AND event_group_id = :group_id', [
                    ':name' => $name,
                    ':bukid' => $bukid,
                    ':group_id' => $group_id
                ])->queryScalar();
        } else {
            $selected = Yii::$app->db
                ->createCommand('
                SELECT id FROM  `events_name`
                WHERE `name` = :name
                AND bukid = :bukid', [
                    ':name' => $name,
                    ':bukid' => $bukid
                ])->queryScalar();
        }
        if (empty($selected)) {
            Yii::$app->db
                ->createCommand('
                INSERT INTO `events_name` (`id`, `name`, `bukid`, `event_group_id`) 
                VALUES (NULL, :name, :bukid, :group_id)', [
                    ':name' => $name,
                    ':bukid' => $bukid,
                    ':group_id' => $group_id
                ])->execute();
            $selected = Yii::$app->db
                ->getLastInsertID();
        }
        return $selected;
    }
    // insert event group name
    public function insertEventGroupName($name, $bukid)
    {
        $selected = Yii::$app->db
            ->createCommand('
                SELECT id FROM  `events_group`
                WHERE `name` = :name
                AND bukid = :bukid', [
                ':name' => $name,
                ':bukid' => $bukid
            ])->queryScalar();
        if (empty($selected)) {
            Yii::$app->db
                ->createCommand('
                INSERT INTO `events_group` (`id`, `name`, `bukid`) 
                VALUES (NULL, :name, :bukid)', [
                    ':name' => $name,
                    ':bukid' => $bukid
                ])->execute();
            $selected = Yii::$app->db
                ->getLastInsertID();
        }
        return $selected;
    }
}
