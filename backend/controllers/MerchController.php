<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use backend\models\merchants\Merchant;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * Site controller
 */
class MerchController extends Controller
{
    public $merch;

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
        $merch = new Merchant();
        $data = $merch->find();

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
                    'label' => 'Поставщик',
                    'options' => ['width' => '70'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'delete') {
                            return \yii\helpers\Url::toRoute(['merch/delete', 'id' => $model['id']]);
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
                                    'confirm' => 'Вы уверены, что хотите удалить поставщика?',
                                ]
                            ]);
                        },
                    ],
                ],
            ],
        ]);

        return $this->render('index.twig', ['data' => $grid]);
    }


    public function actionAdd()
    {

        $this->merch = new Merchant();
        $request = Yii::$app->request->get();

        $this->merch->name = $request['merch'];


        return $this->merch->save() ? $this->redirect(['merch/index', ''],
            301) : 'Не добавился. Для уточнения информации свяжитесь с администратором';
    }

    public function actionDelete()
    {
        $uid = Yii::$app->request->get('id');

        return Merchant::deleteAll(['=', 'id', $uid]) ? $this->redirect(['merch/index', ''],
            301) : 'Не удалился. Для уточнения информации свяжитесь с администратором';
    }

}