<?php

namespace backend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\MainForm;
use yii\helpers\Html;
use backend\models\catalog\Catalog;

/**
 * Site controller
 */
class CatalogController extends Controller
{
    private $_listsection;

    public $catalog;

    public $branch;

    public function init()
    {
        parent::init();
        $this->catalog = new Catalog;
    }

    public function behaviors()
    {
        return [];
    }

    /**
     * @return mixex ListofAllSections
     */
    public function actionIndex()
    {
        foreach ($this->catalog->getAllSections() as $sc) {
            $this->_listsection .= '<li>' . $sc['name'] . '</li>';
        }

        return $this->render('index.twig', ['sections' => $this->_listsection]);
    }

    public function actionAddsection()
    {
        $request = Yii::$app->request;

        $this->branch = $this->catalog->addNewBranch($request->get());

        return $this->redirect(['catalog/index'],301);
    }
}