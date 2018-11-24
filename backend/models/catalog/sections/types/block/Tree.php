<?php

namespace backend\models\catalog\sections\types\block;

use backend\models\catalog\sections\types\block\Block;
use yii\base\BaseObject;


class Tree extends BaseObject implements Block
{
    public $tree = [];

    public $result;

    public function formData($request)
    {
        return self::renderHierarchy();
    }

    private function renderHierarchy()
    {

        foreach ($this->tree as $leaf) {
            $this->result .= '<li class="main-item">' . $leaf['name'] . $this->_renderPartHierarchy($leaf['items']) . '</li>';
        }

        return $this->result;

    }

    public function treeForApi(){
        return $this->tree;
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
}