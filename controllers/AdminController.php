<?
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\users;
use app\models\leages;
use app\models\rates;
use app\models\rates_matches;
use app\models\matches;
use app\models\teams;

class AdminController extends Controller
{
	public $enableCsrfValidation = false;
	public $layout = false;
	
	public function behaviors()
{
    return [
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index'],
                    'roles' => ['admin'],
                ],
				[
                    'allow' => true,
                    'actions' => ['rates'],
                    'roles' => ['admin'],
                ],
				[
                    'allow' => true,
                    'actions' => ['rateadd'],
                    'roles' => ['admin'],
                ],
            ],
        ],
    ];
}
	
    public function actionIndex()
	{
		  $this->layout ='adminloyout'; 
		  return $this->render('index'); 
    }
	public function actionLogin()
	{
		$request = Yii::$app->request;
		$post = $request->post();
		$identity = users::findOne([ 'email' => $post['email'],'password' => $post['password'] ]);
		// logs in the user
		if($identity)
		{
			Yii::$app->user->login($identity);
			return $this->render('index');
		}else{
			   return $this->render('logingform');
		     }

	}
	public function actionLogout()
	{
		Yii::$app->user->logout();
		return $this->render('logingform');
	}
	//
	public function actionRates()
	{
		Yii::$app->view->params['page'] = 6;
		$this->layout = 'adminloyout';
		$matches = matches::find()->asArray()->all();
		  
		  for($i=0;$i<count($matches);$i++)
		  {
		   $team1 = teams::find()->where(['id' => $matches[$i]['team1']])->one();
		   $team2 = teams::find()->where(['id' => $matches[$i]['team2']])->one();
		   $matches[$i]['team1_name'] = $team1->name;
		   $matches[$i]['team2_name'] = $team2->name;
		  }
		  
		$rates = rates::find()->asArray()->all();
		return $this->render('rates',['rates'=>$rates,'matches'=>$matches]);
	}
	//
	public function actionRateadd()
	{
		$rate = new rates_matches();
		$rate->rate = $_POST['rate'];
		$rate->rates_id = $_POST['rate_id'];
		$rate->match_id = $_POST['match_id'];
		$rate->save();
		return $this->redirect('/admin/rates',302);
	}
}
?>