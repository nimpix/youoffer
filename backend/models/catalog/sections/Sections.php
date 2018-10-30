<?php

namespace backend\models\catalog\sections;

use yii\db\ActiveRecord;
use creocoder\nestedsets\NestedSetsBehavior;
use backend\models\products\Products;


class Sections extends ActiveRecord {
 
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
                'leftAttribute' => 'lft',
                'rightAttribute' => 'rgt',
                'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new SectionsQuery(get_called_class());
    }

    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['id' => 'products_id'])
            ->viaTable('products_sections', ['sections_id' => 'id']);
    }

}