<?php

namespace backend\models\catalog\sections;

use yii\db\ActiveQuery;
use creocoder\nestedsets\NestedSetsQueryBehavior;

class SectionsQuery extends ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}