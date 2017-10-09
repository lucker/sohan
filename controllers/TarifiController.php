<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
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
            $sql = "INSERT INTO orders(interkassa_id, amount, confirmed, ik_cur) VALUES ('{$_POST['ik_pm_no']}', {$_POST['ik_am']}, 1, ik_cur)";
            $command = $connection->createCommand($sql);
            $command->execute();
        }
    }
    public function actionThanks()
    {
        /*echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        echo "Оплата успешно прошла";*/
        echo 'thanks';
    }
}