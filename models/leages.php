<?
namespace app\models;
use yii\db\ActiveRecord;

class leages extends ActiveRecord
{
  public function add($name)
  {
    $this->name = $name;
    $this->save();
  }
	
}
?>