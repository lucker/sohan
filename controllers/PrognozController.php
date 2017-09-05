<?
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\prognoz;
use app\models\leages;
use app\models\teams;
use app\models\matches;
use app\models\user_match_rate;
use app\models\users;
use app\models\money;
use app\models\bot;

class PrognozController extends Controller
{
	public $enableCsrfValidation = false;

	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'add', 'matches','rates'],
                'rules' => [
                    [
                        'allow' => false,
                        'actions' => ['index', 'add', 'matches','rates'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','add','matches','rates'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

	public function actionIndex()
	{
		$leages = leages::find()->orderBy('id')->asArray()->all();
		$user = users::find()->where(['id'=>Yii::$app->user->id])->one();
		$money = money::find()->where(['user_id'=>Yii::$app->user->id])->one();
		
		Yii::$app->view->params['user'] = $user;
		return $this->render('index',['leages'=>$leages,'money'=>$money]);
	}
	// добавление ставки
	public function actionAdd()
	{
	   $request = Yii::$app->request;
	   $post = $request->post();
	   //прогноз юзера
	   for($i=0;$i<count($post['rates']);$i++)
	   {
        $rate = new user_match_rate();
	    $rate->user_id = Yii::$app->user->id;
	    $rate->rate_id = $post['rates'][$i];
		$rate->date = date("Y-m-d H:i:s");
		$rate->money = $_POST['money'];
	    $rate->save();
		$money = money::find()->where(['user_id'=>Yii::$app->user->id])->one();
        $money->money = $money->money-$_POST['money'];
        $money->save();
	   }
	   //echo "Прогноз добавлен";
		return $this->redirect('/',302);
	}
	//
	public function actionMatches()
	{
		$request = Yii::$app->request;
	    $post = $request->post();
		
		$matches = matches::find()
		->where(['leage' => $post['leage']])
		->andWhere('date>"'.date("Y-m-d H:i:s").'"')
		->asArray()->all();
		for($i=0;$i<count($matches);$i++)
		{
		 $team1 = teams::find()->where(['id' => $matches[$i]['team1']])->one();
		 $team2 = teams::find()->where(['id' => $matches[$i]['team2']])->one();
		 $matches[$i]['team1'] = $team1->name;
		 $matches[$i]['team2'] = $team2->name;
	    }
		echo json_encode($matches);
	}
	//
	public function actionRates()
	{
		$request = Yii::$app->request;
	    $post = $request->post();
		$rows = (new \yii\db\Query())
         ->select(['id'=>'test_rates.id','test_rates.T','test_rates.C','test_rates.P','test_rates.G','rates.name'])
         ->from(['matches','test_rates','rates'])
         ->where('test_rates.match_id=matches.id')
		 ->andWhere('matches.id='.$post['match'])
		 ->andWhere('test_rates.T=rates.id')
         ->all();
	    return  json_encode($rows);
	}
	//добавления прогноза на новую страницу
	public function actionP()
	{
		$leages = leages::find()->orderBy('id')->asArray()->all();
		$money = money::find()->where(['user_id'=>Yii::$app->user->id])->one();
		
		
		return $this->render('p',['leages'=>$leages,'money'=>$money]);
	}
	public function actionAddp()
	{
		//прогноз юзера
         $rate = new user_match_rate();
	     $rate->user_id = Yii::$app->user->id;
	     $rate->rate_id = $_POST['rates'];
		 $rate->date = date("Y-m-d H:i:s");
		 $rate->money = $_POST['money'];
	     $rate->save();
		 $money = money::find()->where(['user_id'=>Yii::$app->user->id])->one();
         $money->money = $money->money-$_POST['money'];
         $money->save();
		//добавляю прогноз
		$p = new Prognoz();
		$p->match = $_POST['match'];
        $p->text = $_POST['editor1'];
		$p->date = date("Y-m-d H:i:s");
		$p->author = Yii::$app->user->id;
		$p->ratevalue = $rate->id;
        $p->save();
		return $this->redirect('/prognoz/view',302);
	}
	//прогнозы на странице
	public function actionView()
	{
		Yii::$app->view->params['page'] = 4;
		//мета теги
		Yii::$app->view->params['title'] = 'Прогнозы на футбол - sohan.xyz';
		Yii::$app->view->params['description'] = 'Прогнозы на футбол - sohan.xyz';
		//
		$p = (new \yii\db\Query())
         ->select(['prognoz.text','prognoz.author','users.name','leage'=>'leages.name','matches.team1','matches.team2','prognoz.date','prognoz.id','C'=>'test_rates.C','ratename'=>'rates.about','sum'=>'user_match_rate.money'])
         ->from(['prognoz','users','matches','leages','test_rates','rates','user_match_rate'])
         ->where('prognoz.author=users.id')
		 ->andWhere('matches.id=prognoz.match')
		 ->andWhere('matches.leage=leages.id')
		 ->andWhere('user_match_rate.id=prognoz.ratevalue')
		 ->andWhere('rates.id=test_rates.T')
		 ->andWhere('user_match_rate.rate_id=test_rates.id')
		 ->orderBy(['prognoz.date'=> SORT_DESC])
         //->offset(15*$_GET['p'])
		 //->limit(15)
         ->all();
		 for($i=0;$i<count($p);$i++)
		 {
			$t1 = teams::find()->where([ 'id'=>$p[$i]['team1'] ])->one(); 
			$t2 = teams::find()->where([ 'id'=>$p[$i]['team2'] ])->one(); 
			$p[$i]['t1'] = $t1->name;
			$p[$i]['t2'] = $t2->name;
		 }
		 //$m = matches::find()->asArray()->all();
		return $this->render('view',['p'=>$p]);
	}
    //отдельный прогноз
	public function actionPview()
	{
		//
		  $p = (new \yii\db\Query())
         ->select(['prognoz.text','prognoz.author','users.name','leage'=>'leages.name','matches.team1','matches.team2','prognoz.date','prognoz.id','dd'=>'matches.date'])
         ->from(['prognoz','users','matches','leages'])
         ->where('prognoz.author=users.id')
		 ->andWhere('matches.id=prognoz.match')
		 ->andWhere('matches.leage=leages.id')
		 ->andWhere('prognoz.id='.$_GET['id'])
         ->all();
		 for($i=0;$i<count($p);$i++)
		 {
			$t1 = teams::find()->where([ 'id'=>$p[$i]['team1'] ])->one(); 
			$t2 = teams::find()->where([ 'id'=>$p[$i]['team2'] ])->one(); 
			$p[$i]['t1'] = $t1->name;
			$p[$i]['t2'] = $t2->name;
		 }
		//мета теги
		Yii::$app->view->params['title'] = 'Прогноз на матч '.$p[0][t1].'-'.$p[0][t2].' '.$p[0]['dd'];
		Yii::$app->view->params['description'] = 'Прогноз на матч '.$p[0][t1].'-'.$p[0][t2];
		 //$m = matches::find()->asArray()->all();
		return $this->render('pview',['p'=>$p]);
	}
	//
	public function actionPrate()
	{
	  //
		$p = prognoz::find()
		 ->where( ['id' => $_POST['id'] ] )
		 ->one();
		$p->ratevalue = ($p->userrated*$p->ratevalue+$_POST['val'])/($p->userrated+1);
		$p->userrated++;
		$p->save();
		echo $p->ratevalue;
	}
	//
	public function actionBot()
	{
		$bot = new bot();
		$bot->creat2();
	}
	//
    public function actionCreate()
    {
        //echo '123';
        return Yii::$app->controller->renderPartial('create/dist/index');
    }
}
?>