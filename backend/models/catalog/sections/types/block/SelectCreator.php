<?php

namespace backend\models\catalog\sections\types\block;

use backend\models\catalog\sections\types\SectionsFactory;
use yii;


class SelectCreator extends SectionsFactory
{
    public function factory()
    {
        $tree_object = Yii::createObject( [
            'class' => Select::class
        ]);

        return $tree_object;
    }

}
