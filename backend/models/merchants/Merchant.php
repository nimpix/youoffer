<?php

namespace backend\models\merchants;

use yii\db\ActiveRecord;
use backend\models\brands\Brands;

class Merchant extends ActiveRecord
{
    public function getBrands() {
        return $this->hasMany(Brands::className(), ['id' => 'brands_id'])
            ->viaTable('brands_merchant', ['merchant_id' => 'id']);
    }
}