<?
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
use app\models\rates_matches;
use app\models\test_rates;
use app\models\marathonbet;

include $_SERVER['DOCUMENT_ROOT']."/parser/simple_html_dom.php";
include $_SERVER['DOCUMENT_ROOT']."/parser/phpQuery.php";

class ParsController extends Controller
{
	public $enableCsrfValidation = false;
	//
	public function actionP2()
	{
	  $url = 'https://1xbetua.com/LineFeed/Get1x2_Zip?sports=1&count=100&tz=2&mode=4&country=2&partner=25';


	    $opts = array('http'=>array('method'=>"GET",'header'=>"Accept-language: ru\r\n"."Cookie: lng=ru\r\n",'user_agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36'));
        $context = stream_context_create($opts);
        $html = file_get_html($url,false,$context);
		$ar = json_decode($html);
		for($i=0;$i<count($ar->Value);$i++)
		{		    
			$date = date("Y-m-d H:i:s",$ar->Value[$i]->S);
			//лига
			$name = $ar->Value[$i]->L;
			$l = leages::find()->where(['name' => $name])->one();
		    //есть ли лига
				if(!$l)
		        {
			     $l = new leages();
			     $l->name = $name;
				 $l->save();
		        }
			//команда
			$t1 = teams::find()->where( ['name' => $ar->Value[$i]->O1 ])->one();
			$t2 = teams::find()->where( ['name' => $ar->Value[$i]->O2 ])->one();
				if(!$t1)
				{
					$t1 = new teams();
					$t1->name = $ar->Value[$i]->O1;
					$t1->save();
				}
				if(!$t2)
				{
					$t2 = new teams();
					$t2->name = $ar->Value[$i]->O2;
					$t2->save();
				}
			//матчи
		    $m = matches::find()->where(['team1'=>$t1->id,'team2'=>$t2->id,'leage'=>$l->id,'date'=>$date])->one();
			if(!$m)
			{
			 $m = new matches();
			 $m->team1 = $t1->id;
			 $m->team2 = $t2->id;
			 $m->leage = $l->id;
			 $m->date = $date;
			 $m->save(); 
			}
			//save rates 1-6
			for($j=0;$j<=count($ar->Value[$i]->E);$j++)
			{
			 $rates_matches = test_rates::find()->where(['match_id'=>$m->id,'T'=>$ar->Value[$i]->E[$j]->T])->one();
			 
			 if(!$rates_matches)
			 {
				if($ar->Value[$i]->E[$j]->T==NULL){ continue; }
				if($ar->Value[$i]->E[$j]->P==NULL){ $ar->Value[$i]->E[$j]->P=0; }
			    $rates_matches = new test_rates();
			    $rates_matches->match_id = $m->id;
				echo $m->id.' '.$rates_matches->match_id.'<br>';
				$rates_matches->C = $ar->Value[$i]->E[$j]->C;
				$rates_matches->G = $ar->Value[$i]->E[$j]->G;
				$rates_matches->P = $ar->Value[$i]->E[$j]->P;
				$rates_matches->T = $ar->Value[$i]->E[$j]->T;
			    $rates_matches->save();
			 }
			}
		}
	}
	public function actionMarathonbet()
	{
	  $marathonbet = new marathonbet();
	  $marathonbet->parse();
	}
	

	
	public function actionTest()
	{
			      //атрибуты
	      /*$tbodys = pq($el)->find('table.foot-market>tbody');
	      foreach($tbodys as $tbody)
		  {
			  $attr = pq($tbody)->attr('data-event-treeid');
			  $url2 = 'https://www.marathonbet.com/su/events.htm?id='.$attr;
			  echo $url2.'<br>';	
		  }*/
		  //$url2 = 'https://www.marathonbet.com/su/events.htm?id=4886260';	
		
		$url = 'https://www.marathonbet.com/su/events.htm?id=4886260';
	    $html = file_get_contents($url);
        $document = \phpQuery::newDocument($html);
		//фора
		$fora = $document->find('[data-mutable-id="Block_2"]');
		$tables = pq($fora)->find('table.td-border');
	    foreach($tables as $table)
		{
		  //echo 'table';
		  $trs = pq($table)->find('tr');
		  foreach($trs as $tr)
		  {
		   $tds = pq($tr)->find('td');
		   foreach($tds as $td)
		   {
			 $p = pq($td)->find('div>div.coeff-handicap');
			 $c = pq($td)->find('div>div.coeff-price>span');
			 $str_p = str_replace(array(")","("),'',pq($p)->text());
			 $str_c = pq($c)->text();
			 echo $str_p.' '.$str_c.';';
		   }
		   echo '<br>';
		  //print_r($tds->text());
		  }
		}
	    //print_r($test);
	}
	
}

?>