<?php
namespace backend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\MainForm;

/**
 * Site controller
 */
class CatalogController extends Controller
{
    public function behaviors()
    {
        return [];
    }

    public function actionIndex()
    {   
       return $this->render('index');
    }
}