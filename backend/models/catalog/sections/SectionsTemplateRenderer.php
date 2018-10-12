<?php

namespace backend\models\catalog\sections;

use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

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

        foreach($tree as $leaf){
            $this->result .= '<li>' . $leaf['name'] . '<ul>' . $this->_renderPartHierarchy($leaf['items']) .'</ul>' . '</li>';
        }

        return $this->result;

    }

    private function _renderPartHierarchy($tree){

        foreach($tree as $leaf){
            for($i=0;$i<$leaf['depth'];$i++){
                $leaf['depth'] .= '-';
            }
            $this->result .= '<li>' . preg_replace('/(\d)/','',$leaf['depth']) . $leaf['name'] . $this->_renderPartHierarchy($leaf['items']) . '</li>';
        }
    }

    public function renderList()
    {

        $tree = new Sections();

        $res = $tree->find()->all();

        $tree = ArrayHelper::toArray($res, [
            Sections::class => [
                'id',
                'name',
                'depth'
            ]
        ]);

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
                'id',
                'name',
                'depth',
            ],
        ]);

        return $render;
    }

    public function renderSelectList()
    {
        $tree = new Sections();

        $res = $tree->find()->all();

        $result = '';

        foreach ($res as $item){
            $result .= '<option>' . $item->name . '</option>';
        }

        return $result;
    }

}