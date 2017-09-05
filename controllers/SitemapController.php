<?
namespace app\controllers;

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
use app\models\money;
use app\models\articles;

class SitemapController extends Controller
{
	 public function actionCreat()
	 {
		 $p = prognoz::find()->orderBy('id')->asArray()->all();
		 $a = articles::find()->orderBy('id')->asArray()->all();
		 $date='<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		 $date .= '<url><loc>https://'.$_SERVER['SERVER_NAME'].'</loc></url>';
		 $date .= '<url><loc>https://'.$_SERVER['SERVER_NAME'].'/articles</loc></url>';
		 $date .= '<url><loc>https://'.$_SERVER['SERVER_NAME'].'.site/bet</loc></url>';
		 for($i=0;$i<count($p);$i++)
		 {
			   $date .= '<url><loc>https://'.$_SERVER['SERVER_NAME'].'/prognoz/'.$p[$i]['id'].'</loc></url>';
		 }
		 for($i=0;$i<count($a);$i++)
		 {
			 $date .= '<url><loc>https://'.$_SERVER['SERVER_NAME'].'/articles/'.$a[$i]['url'].'</loc></url>';	
		 }
		 $date .= '</urlset>';
		 file_put_contents($_SERVER['DOCUMENT_ROOT'].'/web/sitemap.xml',$date);
	 }
}