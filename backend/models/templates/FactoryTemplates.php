<?php

namespace backend\models\templates;

use models\templates\processors\DefaultProcessor;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

class FactoryTemplates
{
    public function createTemplate($post,$name)
    {
        switch($name){
         //   case 'Wildsport': return Yii::createObject(Wildsport::class,[$this->filepath, $this->name, $post['parser-name']]);
            default: return Yii::createObject(DefaultProcessor::class,[$post, $name]);
        }
    }

    public static function getAllProcessorsData(){

        $template = Templates::find()->asArray()->all();

        $provider = new ArrayDataProvider([
            'allModels' => $template,
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
                    'label' => 'Шаблон название',
                    'options' => ['width' => '70'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}{update}',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'update') {
                            return \yii\helpers\Url::toRoute(['templates/update', 'id' => $model['id']]);
                        }
                        if ($action === 'delete') {
                            return \yii\helpers\Url::toRoute(['templates/delete', 'id' => $model['id']]);
                        }
                    },
                    'header' => 'Действия',
                    'options' => ['width' => '30'],
                    'headerOptions' => ['style' => 'color:#337ab7'],
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a(
                                '<span class="fas fa-pen"></span>',
                                $url,
                                [
                                    'title' => 'Изменить',
                                ]
                            );
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="fas fa-ban"></span>', $url, [
                                'title' => 'Удалить',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => 'Вы уверены, что хотите удалить шаблон?',
                                ]
                            ]);
                        },
                    ],
                ],
            ],
        ]);

        return $grid;
    }
}