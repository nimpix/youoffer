<?php

namespace backend\models\catalog\sections\types\block;

use backend\models\catalog\sections\types\SectionsFactory;
use yii;


class ListViewCreator extends SectionsFactory
{
    public function factory()
    {
        return Yii::createObject( Listdata::class );
    }
}