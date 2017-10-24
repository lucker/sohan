<?
namespace tests\models;
use app\models\LoginForm;
use app\models\users;
class FirstTest extends \Codeception\Test\Unit
{
    public function testAbc()
    {
        $model = new LoginForm([
            'email' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        /*
        $model = new LoginForm([
            'email' => 'igorsohan20@gmail.com',
            'password' => '1q2w3e4r5t',
        ]);*/

        $auth = users::find()->where(['password' => $model->password, 'email' => $model->email])->one();
        if ($auth) {
            \Yii::$app->user->login($auth);
        }
        expect_that(\Yii::$app->user->isGuest);
    }
}
?>