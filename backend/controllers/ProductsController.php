<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use backend\models\currency\Currency;
use yii\data\ActiveDataProvider;
use backend\models\products\Products;
use backend\models\products\ProductProvider;

class ProductsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [''],
                        'allow' => true,
                        'roles' => ['manager-role', 'product-role'],
                    ],
                    [
                        'actions' => ['index', 'add', 'delete', 'update'],
                        'allow' => true,
                        'roles' => ['admin-role'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $product = new ProductProvider();

        $data = Products::find()
            ->joinWith(['merchant' => function($q){$q->select(['name']);}])
            ->joinWith(['brands' => function($q){$q->select(['name']);}]);

        $provider = new ActiveDataProvider([
            'query' => $data,
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        $grid = GridView::widget([
            'dataProvider' => $provider,
            'columns' => [
                [
                    'attribute' => 'id',
                    'format' => 'text',
                    'label' => 'id',
                    'options' => ['width' => '10'],

                ],
                [
                    'attribute' => 'name',
                    'format' => 'text',
                    'label' => 'Наименование',
                    'options' => ['width' => '70'],
                ],
                [
                    'attribute' => 'merchant.name',
                    'format' => 'text',
                    'label' => 'Поставщик',
                    'options' => ['width' => '70'],
                ],
                [
                    'attribute' => 'brands.name',
                    'format' => 'text',
                    'label' => 'Бренд',
                    'options' => ['width' => '70'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'delete') {
                            return \yii\helpers\Url::toRoute(['products/delete', 'id' => $model['id']]);
                        }
                        if ($action === 'update') {
                            return \yii\helpers\Url::toRoute([
                                'products/update',
                                'id' => $model['id'],
                                'name' => $model['name']
                            ]);
                        }
                    },
                    'header' => 'Действия',
                    'options' => ['width' => '20'],
                    'headerOptions' => ['style' => 'color:#337ab7'],
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a('<span class="fas fa-pen"></span>', $url, [
                                'title' => 'Изменить',
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="fas fa-ban"></span>', $url, [
                                'title' => 'Удалить',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => 'Вы уверены, что хотите удалить товар?',
                                ]
                            ]);
                        },
                    ],
                ],
            ],
        ]);

        return $this->render('index.twig', ['data' => $grid]);
    }

    public function actionDelete()
    {
        return false;
    }

    public function actionUpdate()
    {
        return false;
    }

}