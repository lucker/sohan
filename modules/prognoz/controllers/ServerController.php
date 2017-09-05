<?php
/**
 * Created by PhpStorm.
 * User: luckeri20
 * Date: 24.06.2017
 * Time: 15:57
 */

namespace app\modules\prognoz\controllers;
use Yii;
use yii\web\Controller;

class ServerController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * Букмекерские конторы
     * @return string
     */
    public function actionAllbets()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET, POST, PUT');
        $bets = Yii::$app->db
            ->createCommand('SELECT * FROM  `bukcontor`')
            ->queryAll();
        echo json_encode($bets);
    }

    /**
     * Все лиги
     */
    public function actionGetallleages()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        $request = json_decode(file_get_contents("php://input"));
       // header('Access-Control-Allow-Methods: GET, POST, PUT');
        $leages = Yii::$app->db
            ->createCommand('
                SELECT * FROM  leages
                WHERE `bukid` = :BUKID 
                ORDER BY leages.name ASC
            ')
            ->bindValue(':BUKID',$request->id)
            ->queryAll();
        echo json_encode($leages);
    }
    /**
     * Все матчи
     */
    public function actionGetallmatches()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        $request = json_decode(file_get_contents("php://input"));
        $matches = Yii::$app->db
            ->createCommand('
                SELECT 
                    t1.name as team1,
                    t2.name as team2,
                    matches.id
                FROM matches
                LEFT JOIN teams t1 ON matches.team1 = t1.id
                LEFT JOIN teams t2 ON matches.team2 = t2.id
                WHERE matches.leage = :LEAGE
                AND matches.bukid = :BUKID
            ')
            ->bindValue(':BUKID', $request->id)
            ->bindValue(':LEAGE', $request->leage)
            ->queryAll();

        echo json_encode($matches);
    }
    /**
     * Все Тоталы
     */
    public function actionGetalltotals()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        $request = json_decode(file_get_contents("php://input"));
        $totals = Yii::$app->db
            ->createCommand('
                SELECT 
                matches.id,
                totals.handicap,
                totals.odds,
                totals.id as total_id
                FROM totals
                LEFT JOIN matches ON totals.match_id = matches.id
                WHERE totals.match_id = :MATCH_ID
            ')
            ->bindValue(':MATCH_ID', $request->match_id)
            ->queryAll();
        $totalsCorrectFormat = [];
        for ($i=0; $i<count($totals); $i = $i+2) {
            $totalsCorrectFormat[] = [
                'match_id' => $totals[$i]['id'],
                'handicap' => $totals[$i]['handicap'],
                'odds_more' => [$totals[$i]['odds'], $totals[$i]['total_id']],
                'odds_less' => [$totals[$i+1]['odds'], $totals[$i+1]['total_id']],
            ];
        }
        echo json_encode($totalsCorrectFormat);
    }
    /**
     * Создать ивент
     */
    public function actionSendevent()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        $request = json_decode(file_get_contents("php://input"));
        echo $request->id;
    }
}