<?php

namespace backend\models\catalog\sections;

use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;

//сделать фабрику

class SectionsTemplateRenderer
{
    private $_sections;

    public $sect = [];

    public $result = '';

    public function __construct()
    {
        $this->_sections = new Sections();
    }

    private function getAllSectionsBranched()
    {
        $roots = Sections::find()->roots()->addOrderBy('tree, lft')->all();


        foreach ($roots as $root) {
            $this->sect[] = [
                'id' => $root->id,
                'name' => $root->name,
                'depth' => $root->depth,
                'items' => self::getTree($root->children()->all())
            ];
        }
        return $this->sect;

    }

    private function getTree($roots, $lft = 0, $rgt = null, $depth = 1)
    {
        $items = [];

        foreach ($roots as $root) {
            if ($root->lft >= $lft + 1 && $root->depth == $depth && ($root->rgt <= $rgt || is_null($rgt))) {
                $items[] = [
                    'id' => $root->id,
                    'name' => $root->name,
                    'depth' => $root->depth,
                    'items' => self::getTree($roots, $root->lft, $root->rgt, $root->depth + 1)
                ];
            }
        }
        return $items;
    }

    public function renderHierarchy()
    {
        $tree = self::getAllSectionsBranched();

        foreach ($tree as $leaf) {
            $this->result .= '<li class="main-item">' . $leaf['name'] .  $this->_renderPartHierarchy($leaf['items']) .  '</li>';
        }

        return $this->result;

    }

    private function _renderPartHierarchy($tree)
    {

        foreach ($tree as $leaf) {
            for ($i = 0; $i < $leaf['depth']; $i++) {
                $leaf['depth'] .= '-&nbsp;';
            }
            $this->result .= '<li class="second-list">' . preg_replace('/(\d)/', '',
                    $leaf['depth']) . $leaf['name'] . $this->_renderPartHierarchy($leaf['items']) . '</li>';
        }
    }

    public function filterList($name)
    {
        $tree = new Sections();

        $res = empty($name) ? $tree->find()->all() : $tree->find()->where(['LIKE','name', $name])->all();

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
                [   'class' => 'yii\grid\SerialColumn',
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
                            return \yii\helpers\Url::toRoute(['catalog/update', 'id' => $model['id'],'name' => $model['name']]);
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

    public function renderSelectList()
    {
        $tree = new Sections();

        $res = $tree->find()->all();

        $result = '';

        foreach ($res as $item) {
            $result .= '<option>' . $item->name . '</option>';
        }

        return $result;
    }

}