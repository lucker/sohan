<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
class TarifiController extends Controller
{
    public function actionIndex()
    {
        $this->view->title = "Тарифные планы на сайте sohan.xyz";
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Тарифные планы на сайте sohan.xyz'
        ]);
        return $this->render('tarifi');
    }
    public function actionOplata()
    {
        date_default_timezone_set('Etc/GMT-3');
        if (isset($_POST)) {
            // запись бабла
            $connection = Yii::$app->db;
            $userId = str_replace('ID_', '', $_POST['ik_pm_no']);
            $sql = "INSERT INTO orders(user_id, amount, confirmed, ik_cur) VALUES ('{$userId}', {$_POST['ik_am']}, 1, ik_cur)";
            $command = $connection->createCommand($sql);
            $command->execute();
            // запись даты польззования
            $sql = "
                SELECT time
                FROM users
                WHERE id = {$userId}
            ";
            $time = $connection->createCommand($sql)->queryScalar();
            if ($time<date('Y-m-d H:i:s')) {
                $days = 0;
                $date = new \DateTime(date('Y-m-d H:i:s'));
                switch ($_POST['ik_am']) {
                    case 26: $days = 1; break;
                    case 156: $days = 7; break;
                    case 520: $days = 30; break;
                    case 1040: $days = 90; break;
                }
                $date->add(new \DateInterval('P'.$days.'D'));
                $newTime = date_format($date, 'Y-m-d H:i:s');
                $sql = "UPDATE users SET `time` = '{$newTime}' WHERE id = {$userId}";
                $command = $connection->createCommand($sql);
                $command->execute();
            } else {
                $days = 0;
                $date = new \DateTime($time);
                switch ($_POST['ik_am']) {
                    case 26: $days = 1; break;
                    case 156: $days = 7; break;
                    case 520: $days = 30; break;
                    case 1040: $days = 90; break;
                }
                $date->add(new \DateInterval('P'.$days.'D'));
                $newTime = date_format($date, 'Y-m-d H:i:s');
                $sql = "UPDATE users SET `time` = '{$newTime}' WHERE id = {$userId}";
                $command = $connection->createCommand($sql);
                $command->execute();
            }
        }
    }
    public function actionThanks()
    {
        return $this->render('thanks');
    }

    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['oplata'],
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }*/
}