<?
namespace app\controllers\admin;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\leages;
use app\models\matches;
use app\models\seasons;
use app\models\teams;
use app\models\points;

class MatchesController extends \app\controllers\AdminController
{
	public $enableCsrfValidation = false;
	public $layout = 'adminloyout';
	//public $layout = false;
	//
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => false,
                        'actions' => ['index'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                ],
				'denyCallback' => function ($rule, $action) 
				{
                 //throw new \Exception('You are not allowed to access this page');
				 return $this->redirect('/admin/login',303);
				},
            ],
        ];
    }
	//index
   /* public function actionIndex()
	{
     Yii::$app->view->params['page'] = 2;
	 $leages = leages::find()->orderBy('id')->asArray()->all();
	 $seasons = seasons::find()->orderBy('id')->asArray()->all();
     return $this->render('index',['leages'=>$leages,'seasons'=>$seasons]);
	} */
	// add
	public function actionAdd()
	{
	   Yii::$app->view->params['page'] = 2;
	   $teams = teams::find()->orderBy('name')->asArray()->all();
	   $leages = leages::find()->asArray()->all();
	   
	  return $this->render('add',['teams'=>$teams,'leages'=>$leages]);
	}
	public function actionAddi()
	{
	    if(isset($_POST['date']))
		{
		 $matches = new matches();
	     $matches->team1 = $_POST['team1'];
	     $matches->team2 = $_POST['team2'];
		 $matches->leage = $_POST['leages'];
		 $matches->date = $_POST['date'];
	     $matches->save();	
		}
	   return $this->redirect('/admin/matches/add',302);
	}
	public function actionPoints()
	{ 
	  Yii::$app->view->params['page'] = 4;
	  $matches = matches::find()
	  ->orderBy(['date'=> SORT_DESC])
	  ->asArray()
	  ->all();
	  $points = points::find()->asArray()->all();
	  
		for($i=0;$i<count($matches);$i++)
		{
		 
		 $flag = 1;
		 for($j=0;$j<count($points);$j++)
		 { 
		  if( $points[$j]['id'] == $matches[$i]['id'] ){ $flag = 0; } 
		 }
		  
		  if( $flag )
		  {
		   $team1 = teams::find()->where(['id' => $matches[$i]['team1']])->one();
		   $team2 = teams::find()->where(['id' => $matches[$i]['team2']])->one();
		   $leage = leages::find()->where(['id' => $matches[$i]['leage']])->one();
		   $matches[$i]['team1_name'] = $team1->name;
		   $matches[$i]['team2_name'] = $team2->name;
		   $matches[$i]['leage_name'] = $leage->name;
		  }
		  
	    }
	  return $this->render('points',['matches'=>$matches]);
	}
	public function actionAddpoints()
	{
		print_r($_POST);
		for($i=0;$i<count($_POST['team1']);$i++)
		{
		   if($_POST['score1'][$i]!='')
		   {
			   $points = new points();
			   $points->team1 = $_POST['score1'][$i];
			   $points->team2 = $_POST['score2'][$i];
			   $points->id = $_POST['id'][$i];
			   $points->save();
		   }
		}
		return $this->redirect('/admin/matches/points',302);
	}
}
?>