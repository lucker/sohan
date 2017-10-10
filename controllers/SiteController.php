<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\models\users;
use app\models\RegistrationForm;
use app\models\LoginForm;

class SiteController extends Controller
{
	public $enableCsrfValidation = false;
	public function beforeAction($action)
    {
        /*echo '<pre>';
        print_r(Yii::$app->user->identity->email);
        echo '</pre>';
        exit;*/
        return parent::beforeAction($action);
    }
    public function actionIndex()
	{
        $this->view->title = "Сканер вилок, онлайн сканер футбольных вилок - sohan.xyz";
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Сервис по онлайн поиску букмекерских вилок - sohan. Обновление каждые 5 минуты!'
        ]);
        // Yii::$app->user->can('prematch_vilki')

        //
        return $this->render('index');
    }
	// login
	public function actionLogin()
	{
        $model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $isemail = users::find()->where(['email' => $model->email])->one();
		    if ($isemail) {
		        $auth = users::find()->where(['password' => $model->password,'email' => $model->email])->one();
			    if ($auth) {
				    Yii::$app->user->login($auth);
				    return $this->redirect('/site/index',302);
			    } else {
				    echo '<span style="color:red">Password не правильний</span>';
				    return $this->render('login', ['model' => $model]);
                }
		    } else {
		        echo '<span style="color:red">Такого пользователя не существует</span>';
                return $this->render('login', ['model' => $model]);
		    }
        } else {
		    return $this->render('login', ['model' => $model]);
		}
	}
	// registration
	public function actionRegistration()
	{
        $error = null;
		$model = new RegistrationForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $isemail = users::find()->where(['email' => $model->email])->one();
		    if ($isemail) {
			    return $this->render('registration', ['model' => $model, 'error' => 'Пользователь с такой почтой уже существует']);
	        } else {
		        $user = new users();
	            $user->email = $model->email;
	            $user->password = $model->password;
	            $user->save();
			    $auth = users::find()
                    ->where([
                        'password' => $model->password,
                        'email' => $model->email
                    ])
                    ->one();
			    Yii::$app->user->login($auth);
			    return $this->redirect('/site/index',302);
	        }
        } else {
		    return $this->render('registration', ['model' => $model, 'error' => 'Не прошло валидацию']);
		}
	}
	//logout
	public function actionLogout()
	{
		Yii::$app->user->logout();
		return $this->redirect('/site/index',302);
	}
	//
    public function actionPrematchVilki()
    {
        $this->view->title = "Прематч вилки, сканер прематч вилок";
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Сервис по онлайн поиску букмекерских вилок - sohan. Обновление каждые 5 минуты!'
        ]);
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