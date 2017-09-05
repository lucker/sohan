<?
namespace app\controllers\admin;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
//use app\models\users;
use app\models\seasons;

class SeasonsController extends \app\controllers\AdminController
{
  public $enableCsrfValidation = false;
  public function actionIndex()
  {
    $seasons = seasons::find()->asArray()->all();   
    return $this->render('index',['seasons'=>$seasons]);
  }
}
?>