<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\leages;
use app\models\users;
use app\models\prognoz;
use app\models\teams;
use app\models\matches;
use app\models\RegistrationForm;
use app\models\LoginForm;
use app\models\userspoints;
use app\models\user_match_rate;
use app\models\money;

class MoneyController extends Controller
{
	public $enableCsrfValidation = false;
	public function actionIndex()
	{		
		return $this->render('index');
	}
}