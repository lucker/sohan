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
use app\models\articles;

class ArticlesController extends Controller
{
	public $enableCsrfValidation = false;
    public function actionIndex()
	{
		// Url::to() calls UrlManager::createUrl() to create a URL
		Yii::$app->view->params['title'] = 'футбольные стратегии ставок - sohan.xyz'; 
		Yii::$app->view->params['description'] = 'футбольные стратегии ставок - sohan.xyz';
        Yii::$app->view->params['page'] = 3;
 		$articles = articles::find()->orderBy('id')->asArray()->all();
		//preview
		/*for($i=0;$i<count($articles);$i++)
		{
		 $preview = '';
		 $articles[$i]['text'] = strip_tags($articles[$i]['text']);
		 for($j=0;$j<strlen($articles[$i]['text']);$j++)
		 {
			if($j==1000){ break; }
			$preview .= $articles[$i]['text'][$j];
		 }
		 $articles[$i]['text'] = $preview;
		}*/
		//
		return $this->render('index',['posts'=>$articles]);
	}
	//просмотр статьи
	public function actionView()
	{
		$article = articles::find()->where(['url'=>$_GET['name']])->one();
		Yii::$app->view->params['title'] = $article->title;
		Yii::$app->view->params['description'] = $article->desc;
		if($article){ return $this->render('view',['article'=>$article]); }
		else{ echo "not found"; }
	}
	//
    public function actionTest()
	{
		return $this->render('test');
	}
}