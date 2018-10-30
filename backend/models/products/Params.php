<?php

namespace backend\models\products;

use backend\models\products\Products;
use yii\helpers\ArrayHelper;

class Params
{
    public static function getParams($get)
    {
        $fieldObj = Products::find()->where(['=', 'id', $get['id']])->all();
        $maincat = ArrayHelper::toArray($fieldObj, [Products::class => [
            'description',
            'image',
            'articul',
            'price_roznica',
            'price_opt',
            'status',
            'waiting',
            'weight',
            'amount',
            'size'
        ],]);

        return $maincat;
    }
}