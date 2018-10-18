<?
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * Users controller
 */
class SettingsController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index.twig');
    }
}