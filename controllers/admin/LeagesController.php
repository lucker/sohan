<?
namespace app\controllers\admin;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\leages;
use app\models\seasons;

class LeagesController extends \app\controllers\AdminController
{
	public $enableCsrfValidation = false;
	public $layout = 'adminloyout';
	
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
                    'actions' => ['addleage'],
                    'roles' => ['admin'],
                ],
				[
                    'allow' => true,
                    'actions' => ['deleteleage'],
                    'roles' => ['admin'],
                ],
				[
                    'allow' => true,
                    'actions' => ['changeleage'],
                    'roles' => ['admin'],
                ],
            ],
         ],
       ];
    }
	
    public function actionIndex()
	{
		Yii::$app->view->params['page'] = 1;
		$leages = leages::find()->orderBy('id')->asArray()->all();
	    return $this->render('leages',['leages'=>$leages]);
    }
	//Addleage
	public function actionAddleage()
	{
		$request = Yii::$app->request;
		$post = $request->post();
		$leage = new leages();
		$leage->name = $post['name'];
		$leage->save();
		//render
		$leages = leages::find()->orderBy('id')->asArray()->all();
		return $this->render('leages',['leages'=>$leages]);
	}
	//Deleteleage
	public function actionDeleteleage()
	{
		//delet leages
		$request = Yii::$app->request;
		$post = $request->post();
		$leages = leages::find()->where(['id' => $post['id']])->one();
		if($leages){ $leages->delete(); }
		//render
		$leages = leages::find()->orderBy('id')->asArray()->all();
		return $this->render('leages',['leages'=>$leages]);
	}
	//Changeleage
	public function actionChangeleage()
	{
		$request = Yii::$app->request;
		$post = $request->post();
		$leage = leages::find()->where(['id' => $post['id']])->one();
		if($leage)
		{
		 $leage->name = $post['name'];
		 $leage->update();
		}
	}

}
?>