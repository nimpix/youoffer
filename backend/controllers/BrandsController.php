<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use backend\models\brands\Brands;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class BrandsController extends Controller
{
    public $brand;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [''],
                        'allow' => true,
                        'roles' => ['manager-role','product-role'],
                    ],
                    [
                        'actions' => ['index','add','delete'],
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
        $brand = new Brands();
        $data = $brand->find();

        $provider = new ActiveDataProvider([
            'query' => $data,
            'pagination' => [
                'pageSize' => 10,
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
                    'label' => 'Брэнд',
                    'options' => ['width' => '70'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'delete') {
                            return \yii\helpers\Url::toRoute(['brands/delete', 'id' => $model['id']]);
                        }
                    },
                    'header' => 'Действия',
                    'options' => ['width' => '30'],
                    'headerOptions' => ['style' => 'color:#337ab7'],
                    'buttons' => [
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="fas fa-ban"></span>', $url, [
                                'title' => 'Удалить',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => 'Вы уверены, что хотите удалить бренд?',
                                ]
                            ]);
                        },
                    ],
                ],
            ],
        ]);

        return $this->render('index.twig', ['data' => $grid]);
    }

    public function actionAllMerchants()
    {
        // Brands::find()->joinWith('merchant')->where(['merchant_id' => 1])->all();
    }

    public function actionAdd()
    {

        $this->brand = new Brands();
        $request = Yii::$app->request->get();

        $this->brand->name = $request['brand'];


        return $this->brand->save() ? $this->redirect(['brands/index', ''],
            301) : 'Не добавился. Для уточнения информации свяжитесь с администратором';
    }

    public function actionDelete()
    {
        $uid = Yii::$app->request->get('id');

        return Brands::deleteAll(['=', 'id', $uid]) ? $this->redirect(['brands/index', ''],
            301) : 'Не удалился. Для уточнения информации свяжитесь с администратором';
    }
}