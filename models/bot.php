<?
namespace app\models;
use Yii;
use app\models\user_match_rate;

class bot
{
	public $id;
	public $money;
	function __construct($id,$money)
	{
		$this->id = $id;
		$this->money = $money;
	}
	// создание ставок ботом на все события с ошибкой кек
	public function creat()
	{
		//все рейты
	    $rows = (new \yii\db\Query())
         ->select(['id'=>'test_rates.id','test_rates.T','test_rates.C','test_rates.P','test_rates.G','rates.name'])
         ->from(['matches','test_rates','rates'])
         ->where('test_rates.match_id=matches.id')
		 ->andWhere('test_rates.T=rates.id')
		 ->andWhere('matches.date>"'.date("Y-m-d H:i:s").'"')
         ->all();
	    //добавить прогноз
		for($i=0;$i<count($rows);$i++)
		{
		  $find = user_match_rate::find()
		   ->where(['user_id'=>$this->id])
		   ->andWhere(['rate_id'=>$rows[$i][id] ])
		   ->one();
		  if( $find ){ continue; }
	      if( $rows[$i][C]>=1.5 ){ continue; }
		  $money = money::find()->where(['user_id'=>$this->id])->one();
		  if( $money->money-$this->money <0 ){ continue; }
		  $rate = new user_match_rate();
	      $rate->user_id = $this->id;
	      $rate->rate_id = $rows[$i][id];
		  $rate->date = date("Y-m-d H:i:s");
		  $rate->money = $this->money;
	      $rate->save();
          $money->money = $money->money-$this->money;
          $money->save();
		}
	}
    
	// создание ставок ботом на все события с кэфом меньше 1.5
	public function creat2()
	{
		//все рейты
	    $rows = (new \yii\db\Query())
         ->select(['id'=>'test_rates.id','test_rates.T','test_rates.C','test_rates.P','test_rates.G','rates.name'])
         ->from(['matches','test_rates','rates'])
         ->where('test_rates.match_id=matches.id')
		 ->andWhere('test_rates.T=rates.id')
		 ->andWhere('matches.date>"2017-04-04 00:00:00"')
		 ->andWhere('matches.date<"2017-04-04 23:59:59"')
         ->all();
	    //добавить прогноз
		for($i=0;$i<count($rows);$i++)
		{
		  $find = user_match_rate::find()
		   ->where(['user_id'=>$this->id])
		   ->andWhere(['rate_id'=>$rows[$i][id] ])
		   ->one();
		  if( $find ){ continue; }
	      if( $rows[$i][C]>=1.5 ){ continue; }
		  $money = money::find()->where(['user_id'=>$this->id])->one();
		  if( $money->money-$this->money <0 ){ continue; }
		  $rate = new user_match_rate();
	      $rate->user_id = $this->id;
	      $rate->rate_id = $rows[$i][id];
		  $rate->date = date("Y-m-d H:i:s");
		  $rate->money = $this->money;
	      $rate->save();
          $money->money = $money->money-$this->money;
          $money->save();
		}
	}
}
?>
