<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\catalog\Catalog;

/**
 * Site controller
 */
class CatalogController extends Controller
{
    private $_listsection;

    public $catalog;

    public $branch;

    public $id;

    public $depth;

    public $name;

    public $items;

    public $lft;

    public $rgt;

    private $_selectsection;

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
        $this->_listsection = $this->catalog->renderTemplateList();
        $hier = $this->catalog->renderTemplateHierarchy();
        $this->_selectsection = $this->catalog->renderTemplateSelectList();

        return $this->render('index.twig',
            ['sections' => $this->_listsection, 'selectsections' => $this->_selectsection, 'hier' => $hier]);
    }

    public function actionAddsection()
    {
        $request = Yii::$app->request;

        $this->branch = $this->catalog->addNewBranch($request->get());

        return $this->redirect(['catalog/index'], 301);
    }

    public function actionDelete()
    {
        $request = Yii::$app->request->get();

        return Catalog::catalogDelete($request);
    }
}