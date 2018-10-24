<?php

namespace backend\models\catalog\sections\types\block;

use backend\models\catalog\sections\types\SectionsFactory;
use yii;


class TreeCreator extends SectionsFactory
{
    public function factory()
    {
        $tree = parent::getAllSectionsBranched();
        
        $tree_object = Yii::createObject( [
            'class' => Tree::class,
            'tree' => $tree
        ]);
        $tree_object->tree = $tree;

        return $tree_object;
    }

}
