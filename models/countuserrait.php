<?
namespace app\models;
use Yii;

class countuserrait
{
	public function countrait()
	{
		 $prognoz = (new \yii\db\Query())
         ->select(['user_match_rate.id','p1'=>'points.team1','p2'=>'points.team2','test_rates.C','user_match_rate.money','test_rates.T','user_match_rate.user_id','test_rates.P'])
		 ->from(['user_match_rate','test_rates','matches','points'])
		 ->Where('user_match_rate.rate_id=test_rates.id')
		 ->andWhere('test_rates.match_id=matches.id')
		 ->andWhere(['user_match_rate.used'=>0])
		 ->andWhere('matches.id=points.id')
		 ->all();
		 
		for($i=0;$i<count($prognoz);$i++)
		{
			switch($prognoz[$i]['T'])
			{
				case '1': 
				   if($prognoz[$i]['p1']>$prognoz[$i]['p2'])
				   {  
				     $money = money::find()
					 ->where( ['user_id' => $prognoz[$i]['user_id']] )
					 ->one();
					 $money->money = $money->money + $prognoz[$i][C]*$prognoz[$i][money];
                     $money->save();
					 $this->used($prognoz[$i][id],1);
				   }else{
				    $this->used($prognoz[$i][id],-1);
				   }
				   break;
			    case '2':
				   if($prognoz[$i]['p1']==$prognoz[$i]['p2'])
				   {  
				     $money = money::find()
					 ->where( ['user_id' => $prognoz[$i]['user_id']] )
					 ->one();
					 $money->money = $money->money + $prognoz[$i][C]*$prognoz[$i][money];
                     $money->save();
					 $this->used($prognoz[$i][id],1);
				   }else{
				   $this->used($prognoz[$i][id],-1);
				   }
				   break;	
				case '3':
				   if($prognoz[$i]['p1']<$prognoz[$i]['p2'])
				   {  
				     $money = money::find()
					 ->where( ['user_id' => $prognoz[$i]['user_id']] )
					 ->one();
					 $money->money = $money->money + $prognoz[$i][C]*$prognoz[$i][money];
                     $money->save();
					 $this->used($prognoz[$i][id],1);
				   }else{
				   $this->used($prognoz[$i][id],-1);
				   }
				   break;
			    case '4':
			  	   if($prognoz[$i]['p1']>$prognoz[$i]['p2']||$prognoz[$i]['p1']==$prognoz[$i]['p2'])
				   {  
				     $money = money::find()
					 ->where( ['user_id' => $prognoz[$i]['user_id']] )
					 ->one();
					 $money->money = $money->money + $prognoz[$i][C]*$prognoz[$i][money];
                     $money->save();
					 $this->used($prognoz[$i][id],1);
				   }else{
				   $this->used($prognoz[$i][id],-1);
				   }
				   break;	
				 case '5':
				 	if($prognoz[$i]['p1']>$prognoz[$i]['p2']||$prognoz[$i]['p1']<$prognoz[$i]['p2'])
				   {  
				     $money = money::find()
					 ->where( ['user_id' => $prognoz[$i]['user_id']] )
					 ->one();
					 $money->money = $money->money + $prognoz[$i][C]*$prognoz[$i][money];
                     $money->save();
					 $this->used($prognoz[$i][id],1);
				   }else{
				   $this->used($prognoz[$i][id],-1);
				   }
				   break;	
				   case '6':
				   	if($prognoz[$i]['p1']<$prognoz[$i]['p2']||$prognoz[$i]['p1']==$prognoz[$i]['p2'])
				   {  
				     $money = money::find()
					 ->where( ['user_id' => $prognoz[$i]['user_id']] )
					 ->one();
					 $money->money = $money->money + $prognoz[$i][C]*$prognoz[$i][money];
                     $money->save();
					 $this->used($prognoz[$i][id],1);
				   }else{
				   $this->used($prognoz[$i][id],-1);
				   }
				   break;	
				   case '7':
				   if($prognoz[$i]['p1']+$prognoz[$i][P]>$prognoz[$i]['p2'])
				   {
					 $money = money::find()
					 ->where( ['user_id' => $prognoz[$i]['user_id']] )
					 ->one();
					 $money->money = $money->money + $prognoz[$i][C]*$prognoz[$i][money];
                     $money->save();
					 $this->used($prognoz[$i][id],1);
				   }else{
				    if($prognoz[$i]['p1']+$prognoz[$i][P]==$prognoz[$i]['p2'])
				    {
					 $money = money::find()
					 ->where( ['user_id' => $prognoz[$i]['user_id']] )
					 ->one();
					 $money->money = $money->money + $prognoz[$i][money];
                     $money->save();
					 $this->used($prognoz[$i][id],2);
				    }else{ $this->used($prognoz[$i][id],-1); } 
				   }
				   break;
				   case '8':
				   if($prognoz[$i]['p2']+$prognoz[$i][P]>$prognoz[$i]['p1'])
				   {
					 $money = money::find()
					 ->where( ['user_id' => $prognoz[$i]['user_id']] )
					 ->one();
					 $money->money = $money->money + $prognoz[$i][C]*$prognoz[$i][money];
                     $money->save();
					 $this->used($prognoz[$i][id],1);
				   }else{
				    if($prognoz[$i]['p2']+$prognoz[$i][P]==$prognoz[$i]['p1'])
				    {
					 $money = money::find()
					 ->where( ['user_id' => $prognoz[$i]['user_id']] )
					 ->one();
					 $money->money = $money->money + $prognoz[$i][money];
                     $money->save();
					 $this->used($prognoz[$i][id],2);
				    }else{ $this->used($prognoz[$i][id],-1); }
				   }
				   break;	
				  case '9':
				   if($prognoz[$i]['p1']+ $prognoz[$i]['p2']>$prognoz[$i][P])
				   {
					 $money = money::find()
					 ->where( ['user_id' => $prognoz[$i]['user_id']] )
					 ->one();
					 $money->money = $money->money + $prognoz[$i][C]*$prognoz[$i][money];
                     $money->save();
					 $this->used($prognoz[$i][id],1);					   
				   }else{ 
				   	if($prognoz[$i]['p2']+$prognoz[$i]['p1']==$prognoz[$i][P])
				    {
					 $money = money::find()
					 ->where( ['user_id' => $prognoz[$i]['user_id']] )
					 ->one();
					 $money->money = $money->money + $prognoz[$i][money];
                     $money->save();
					 $this->used($prognoz[$i][id],2);
				    }else{ $this->used($prognoz[$i][id],-1); }				   
				   }	
				   break;
				  case '10':
				   if($prognoz[$i]['p1']+ $prognoz[$i]['p2']<$prognoz[$i][P])
				   {
					 $money = money::find()
					 ->where( ['user_id' => $prognoz[$i]['user_id']] )
					 ->one();
					 $money->money = $money->money + $prognoz[$i][C]*$prognoz[$i][money];
                     $money->save();
					 $this->used($prognoz[$i][id],1);					   
				   }else{ 
				    if($prognoz[$i]['p2']+$prognoz[$i]['p1']==$prognoz[$i][P])
				    {
					 $money = money::find()
					 ->where( ['user_id' => $prognoz[$i]['user_id']] )
					 ->one();
					 $money->money = $money->money + $prognoz[$i][money];
                     $money->save();
					 $this->used($prognoz[$i][id],2);
				    }else{ $this->used($prognoz[$i][id],-1); }
				   }	
				  break;	
			}
		}
		 
		 
	/*	 echo "<pre>";
		 print_r($prognoz);
		 echo "</pre>"; */
	}
	//записали очки пользователя
	public function used($id,$val)
	{
	    $user_match_rate = user_match_rate::find()
			 ->where(['id' => $id ])
			 ->one();
		     $user_match_rate->used = $val;
		     $user_match_rate->save();
	}
}
?>