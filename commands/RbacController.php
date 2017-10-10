<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        // add "vilki" permission
        $vilki = $auth->createPermission('prematch_vilki');
        $vilki->description = 'Смотреть прематч вилки';
        $auth->add($vilki);
        // role "auth"
        $authuser = $auth->createRole('auth');
        $auth->add($authuser);
        $auth->addChild($authuser, $vilki);
        // role "bought"
        $bought = $auth->createRole('bought');
        $auth->add($bought);
        $auth->addChild($bought, $vilki);
        // $bought -> $authuser
        $auth->addChild($bought, $authuser);
        $auth->assign($bought, 1);

    }
}