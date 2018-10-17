<?php

namespace backend\controllers;

use Yii;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\Controller;
use backend\models\currency\Currency;
use yii\data\ActiveDataProvider;


class CurrencyController extends Controller
{
    public function actionIndex()
    {
        $currency_data = new ActiveDataProvider([
            'query' => Currency::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $grid = GridView::widget([
            'dataProvider' => $currency_data,
            'columns' => [
                [
                    'attribute' => 'id',
                    'format' => 'text',
                    'label' => 'id',
                    'options' => ['width' => '10'],
                    'contentOptions' => ['class' => 'val-id'],
                ],
                [
                    'attribute' => 'name',
                    'format' => 'text',
                    'label' => 'Название',
                    'options' => ['width' => '70'],
                    'contentOptions' => ['class' => 'val-name'],
                ],
                [
                    'attribute' => 'kurs',
                    'format' => 'text',
                    'label' => 'Курс к руб.',
                    'options' => ['width' => '50'],
                    'contentOptions' => ['class' => 'val-kurs'],
                ],
            ],
        ]);

        return $this->render('index.twig', ['data' => $grid]);
    }

    public function actionUpdate()
    {

        $name = Yii::$app->request->post('data');
        $id = Yii::$app->request->post('id');
        $value = Yii::$app->request->post('value');

        $raw = Currency::find()->where(['=', 'id', $id])->all();
        $raw[0]->name = $name;
        $raw[0]->kurs = $value;

        $raw[0]->save();

        return $this->redirect(['currency/index', ''], 301);
    }
}