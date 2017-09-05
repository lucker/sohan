<?
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\matches;
use app\models\points;

class GraphController extends Controller
{
  public $layout = false;
  public function actionGraph()
  {
	    $id=$_GET['id'];
		$ar =array();
	    $p =  (new \yii\db\Query())
         ->select()
         ->from(['user_match_rate','rates','users','test_rates','matches'])
         ->where('user_match_rate.user_id=users.id')
		 ->andWhere('user_match_rate.rate_id=test_rates.id')
		 ->andWhere('test_rates.match_id=matches.id')
		 ->andWhere('rates.id=test_rates.T')
		 ->andWhere('user_match_rate.user_id='.$id)
		 ->andWhere(['<','matches.date',date('Y-m-d').' 23:59:59'])
		 //->andWhere('user_match_rate.used<>0')
		 ->orderBy(['matches.date' => SORT_DESC])
         ->all();
	  //
	  $time = '';
	  for($i=0;$i<count($p);$i++)
	  {
		 if( $time == $this->notime($p[$i]['date']) )
		 {
			$ar[count($ar)-1]['money'] += $p[$i][money];
			if($p[$i][used] == 1){ $ar[count($ar)-1]['win'] += $p[$i][money]*$p[$i][C]; }
			if($p[$i][used] == 2){ $ar[count($ar)-1]['win'] += $p[$i][money]; }
		 }else{ 
		  $ar[]['money'] = $p[$i][money];
		  $ar[count($ar)-1]['date'] = $this->notime( $p[$i]['date'] );
		  $ar[count($ar)-1]['win'] = 0;
		  if($p[$i][used] == 1){ $ar[count($ar)-1]['win'] = $p[$i][money]*$p[$i][C]; }
		  if($p[$i][used] == 2){ $ar[count($ar)-1]['win'] = $p[$i][money]; }
		 }
		 $time = $this->notime($p[$i]['date']);
	  }  
	  /*echo "<pre>";
	  print_r($p);
	  echo "</pre>";*/
	  return $this->render('index',['p'=>$p,'ar'=>$ar]);
  }
  //откинуть время
  public function notime($time)
  {
	 $t = '';
	for($i=0;$i<strlen($time);$i++)
	{
		if($time[$i]==' '){ break; }
		$t = $t.$time[$i];
	}
	return $t;
  }
}
?>