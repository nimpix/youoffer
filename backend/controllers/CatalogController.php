<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
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
            [   'sections' => $this->_listsection, 'selectsections' => $this->_selectsection,
                'hier' => $hier, 'formError' => Yii::$app->request->get('error'),
            ]);
    }

    public function actionAddsection()
    {
        $request = Yii::$app->request;
        $catalog = new Catalog;

        if ($catalog->load(Yii::$app->request->get(), '') && $catalog->validate()) {
            $this->branch = $this->catalog->addNewBranch($request->get());
        }
        $status = Html::error($catalog,'name',['class'=> 'error-body']);
        $status = strip_tags($status);

        if(empty($status)){
            $status = 'Категория успешно добавлена';
        }else{
            $status = 'Название должно содержать не более 50 символов';
        }

        return $this->redirect(['catalog/index','error' => $status], 301);
    }

    public function actionDelete()
    {
        $request = Yii::$app->request->get();

        return Catalog::catalogDelete($request);
    }
}