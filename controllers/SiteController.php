<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Url;

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
use app\models\countuserrait;
use app\models\creatUrl;


class SiteController extends Controller
{
	public $enableCsrfValidation = false;
    public function actionIndex()
	{
        $this->view->title = "Сканер вилок, онлайн сканер футбольных вилок - sohan.xyz";
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Сервис по онлайн поиску букмекерских вилок - sohan. Обновление каждые 5 минуты!'
        ]);
        return $this->render('index');
    }
	// login
	public function actionLogin()
	{
        $model = new LoginForm();

		if ( $model->load(Yii::$app->request->post()) && $model->validate() )
		{
         $isemail = users::find()->where(['email' => $model->email])->one();
		  if($isemail)
	      {
		     $auth = users::find()->where(['password' => $model->password,'email' => $model->email])->one();
			 if( $auth )
			 {
				 Yii::$app->user->login($auth);
				 return $this->redirect('/site/index',302);
			 }else{
				    echo '<span style="color:red">Password не правильний</span>';
				    return $this->render('login', ['model' => $model]);
			      }			    
		  }else{ 
		    echo '<span style="color:red">Такого пользователя не существует</span>';
			return $this->render('login', ['model' => $model]); 
		   }
        }else{ return $this->render('login', ['model' => $model]); }
	}
	// registration
	public function actionRegistration()
	{
		$model = new RegistrationForm();

		if ( $model->load(Yii::$app->request->post()) && $model->validate() )
		{
         $isemail = users::find()->where(['email' => $model->email])->one();
		  if($isemail)
	      {
		      echo '<span style="color:red">Пользователь с такой почтой существует</span>';
			  return $this->render('registration', ['model' => $model]);
	      }else{
		    $user = new users();
	        $user->email = $model->email;
	        $user->password = $model->password;
			$user->name = $model->login;
	        $user->save();
			$auth = users::find()->where(['password' => $model->password,'email' => $model->email])->one();
			$money = new money();
			$money->user_id = $auth->id;
			$money->money = 4000;
			$money->save();
			
			Yii::$app->user->login($auth);
			return $this->redirect('/site/index',302);
	      }
        }else{ return $this->render('registration', ['model' => $model]); }
	}

	//logout
	public function actionLogout()
	{
		Yii::$app->user->logout();
		return $this->redirect('/site/index',302);
	}

	// user_profile+functionality
	public function actionProfile()
	{
		$match= matches::find()->orderBy('id')->asArray()->all();
		return $this->render('profile');
	}
	//about 
	public function actionBet()
	{
		//мета теги
		Yii::$app->view->params['title'] = 'Онлайн ставки на виртуальные деньги - sohan.xyz';
		Yii::$app->view->params['description'] = 'Онлайн ставки на виртуальные деньги - sohan.xyz';
		//
	   $user = users::find()->where(['id'=>Yii::$app->user->id])->one();
	   Yii::$app->view->params['page'] = 2;
	   Yii::$app->view->params['user'] = $user;
	   return $this->render('about');
	}
	//test
	public function actionTest()
	{
		return $this->render('index');
	}
	//конкурс прогнозистов
	public function actionKonkurs()
	{
		//мета теги
		Yii::$app->view->params['title'] = 'Конкурс прогнозов с денежными призами - sohan.xyz';
		Yii::$app->view->params['description'] = 'Конкурс прогнозов с денежными призами - sohan.xyz';
		return $this->render('konkurs');
	}
	//
    public function actionPrematchVilki()
    {
        return $this->render('vilki');
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}