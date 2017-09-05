<?
namespace app\models;
use Yii;
class marathonbet
{
	public function parse()
	{
	  $url = 'https://www.marathonbet.com/su/betting/Football/';
	  $html = file_get_contents($url);
      $document = \phpQuery::newDocument($html);
      $categorys = $document->find('div.category-container');
	  foreach($categorys as $category) 
	  {  
	      $leage = pq($category)->find('table.category-header')->find('h2')->text();
		  	$l = leages::find()->where(['name' => $leage,'bukid' => 2])->one();
		    //есть ли лига
		    if(!$l)
		    {
			     $l = new leages();
			     $l->name = $leage;
				 $l->bukid = 2;
				 $l->save();
		    }
		  echo $leage.'-';
		  $tbodys = pq($category)->find('tbody');
		  foreach($tbodys as $tbody)
		  {
			  $teams = pq($tbody)->find('td')->find('div.nowrap>span');
			  $teams_array = array();
			  foreach($teams as $team)
			  {
				 $teams_array[]= pq($team)->text();
			  }
			  if( $teams_array[0]!=''&&$teams_array[1]!='')
			  {
			  	//команда
			    $t1 = teams::find()->where( ['name' => $teams_array[0],'bukid'=>2 ])->one();
			    $t2 = teams::find()->where( ['name' => $teams_array[1],'bukid'=>2 ])->one();
				if(!$t1)
				{
					$t1 = new teams();
					$t1->name = $teams_array[0];
					$t1->bukid = 2;
					$t1->save();
				}
				if(!$t2)
				{
					$t2 = new teams();
					$t2->name = $teams_array[1];
					$t2->bukid = 2;
					$t2->save();
				}
				$date = trim(pq($tbody)->find('td.date')->text());
			    $date = $this->date($date);
				echo $teams_array[0].' '.$teams_array[1].' '.$date.'<br>';
		        $m = matches::find()
			    ->where(['team1'=>$t1->id,'team2'=>$t2->id,'leage'=>$l->id,'date'=>$date])
			    ->one();
			   if(!$m)
			   {
			    $m = new matches();
			    $m->team1 = $t1->id;
			    $m->team2 = $t2->id;
			    $m->leage = $l->id;
			    $m->date = $date;
			    $m->save();
			   }
			}
			echo "<br>";
			//
		  }
		  
	  }
	}
	private function date($date)
	{
		$res = '';
	    $marray = array('янв','фев','мрт','апр','мая','июн','июл','авг','сен','окт','нбр','дек');
		$m = false;
		for($i=0;$i<count($marray);$i++)
		{
		  if(stristr($date,$marray[$i])){ $m = $i+1; }
		}
		if($m)
		{
		 $y = date('Y');
		 $time = '';
		 $d = $date[0].$date[1];  
		 if($m<10){ $m ='0'.$m; }
		 for($j=strlen($date)-1;$j>=0;$j--)
		 {
			if($date[$j]==' '){ break; }
			$time = $date[$j].$time;
		 }
		 $res = $y.'-'.$m.'-'.$d.' '.$time; 
		}else{ 
		 $res = date("Y-m-d").' '.$date;
		}
		return $res;
	}
}
?>