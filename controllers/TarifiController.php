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
        if (isset($_POST)) {
            $connection = Yii::$app->db;
            $userId = str_replace('ID_', '', $_POST['ik_pm_no']);
            $sql = "INSERT INTO orders(user_id, amount, confirmed, ik_cur) VALUES ('{$userId}', {$_POST['ik_am']}, 1, ik_cur)";
            $command = $connection->createCommand($sql);
            $command->execute();
        }
    }
    public function actionThanks()
    {
        // echo 'error';
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