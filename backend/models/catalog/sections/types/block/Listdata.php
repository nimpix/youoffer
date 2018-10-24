<?php

namespace backend\models\catalog\sections\types\block;

use backend\models\catalog\sections\types\block\Block;
use yii\base\BaseObject;
use backend\models\catalog\sections\Sections;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Listdata extends BaseObject implements Block
{
    public function formData($request)
    {
        $tree = self::filterList($request);
        $render = self::renderList($tree);

        return $render;
    }

    public function filterList($name)
    {
        $tree = new Sections();

        $res = empty($name) ? $tree->find()->all() : $tree->find()->where(['LIKE', 'name', $name])->all();

        $tree = ArrayHelper::toArray($res, [
            Sections::class => [
                'id',
                'name',
                'depth',
                'lft'
            ]
        ]);

        return $tree;
    }

    public function renderList($tree)
    {

        $data = new ArrayDataProvider([
            'allModels' => $tree,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'attributes' => ['id', 'name', 'depth'],
            ],
        ]);

        $render = GridView::widget([
            'dataProvider' => $data,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'options' => ['width' => '20']
                ],
                [
                    'attribute' => 'name',
                    'format' => 'text',
                    'label' => 'Название',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'delete') {
                            return \yii\helpers\Url::toRoute(['catalog/delete', 'id' => $model['id']]);
                        }
                        if ($action === 'update') {
                            return \yii\helpers\Url::toRoute([
                                'catalog/update',
                                'id' => $model['id'],
                                'name' => $model['name']
                            ]);
                        }
                    },
                    'header' => 'Действия',
                    'options' => ['width' => '30'],
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
                                    'confirm' => 'Вы уверены, что хотите удалить категорию?',
                                ]
                            ]);
                        },
                    ],
                ],

            ],
        ]);


        return $render;
    }

}