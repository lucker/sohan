<?
namespace app\controllers\admin;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\prognoz;
use app\models\leages;
use app\models\teams;
use app\models\matches;
use app\models\user_match_rate;
use app\models\users;

class TeamsController extends \app\controllers\AdminController
{
	public $layout = 'adminloyout';
	public $enableCsrfValidation = false;
	public function behaviors()
{
    return [
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index'],
                    'roles' => ['admin'],
                ],
				[
                    'allow' => true,
                    'actions' => ['all'],
                    'roles' => ['admin'],
                ],
				[
                    'allow' => true,
                    'actions' => ['add'],
                    'roles' => ['admin'],
                ],
            ],
        ],
    ];
}
    // index
	public function actionIndex()
	{
	  Yii::$app->view->params['page'] = 3;
	  return $this->render('index');
	}
	// add
	public function actionAdd()
	{
	   $teams = new teams();
	   $teams->name = $_POST['name'];
	   $teams->group = $_POST['group'];
	   $teams->save();
	   return $this->redirect('/admin/teams/index',303);
	}
	// all
	public function actionAll()
	{
	  Yii::$app->view->params['page'] = 5;
	  $teams = teams::find()->orderBy('id')->asArray()->all();
	  return $this->render('all' , ['teams' => $teams]);
	}
}
?>