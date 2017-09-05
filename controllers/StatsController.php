<?

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\matches;
use app\models\points;

class StatsController extends Controller
{
	public $enableCsrfValidation = false;
	public function actionIndex()
	{ 
	   //очки дома
	   $team1 = matches::find()
	   ->where(['team1' => 9])
	   ->asArray()->all();
	   //echo "<pre>";
	   //print_r($team1);
	   //echo "</pre>";
	   for($i=0;$i<count($team1);$i++)
	   {
		   $p = points::find()
	       ->where([ 'id' => $team1[$i]['id'] ])
	       ->asArray()->all();
		   echo "<pre>";
		   print_r($p);
		   echo "</pre>";
	   }
	   
	   
	   
	   
	   return $this->render('index',['t'=>$teams]);
	}
	// конкретная лига
	public function actionView()
	{
	   return $this->render('view');
	}
}
?>