<?
namespace app\models;
use yii\db\ActiveRecord;

class creatUrl
{
	public function creat($rout,$get,$a)
	{
	 foreach($get as $key=>$val)
	 { 
	  if(!isset($a[$key])){ $a[$key]=$val; } 
	 }
	 $params = '';
	 $n = count($a);
	 $i=0;
	 foreach($a as $key=>$val)
	 {
	  $i++;
	  if($n==$i){  $params = $params.$key.'='.$val; }
	  else{ $params = $params.$key.'='.$val.'&'; }
	 }
	 return $rout.'?'.$params;
	}
}
?>