<?php

namespace backend\models\products;

use yii\db\ActiveRecord;
use backend\models\merchants\Merchant;
use backend\models\brands\Brands;

class Products extends ActiveRecord
{
    public function getMerchant() {
        return $this->hasOne(Merchant::className(), ['id' => 'merchant_id']);
    }

    public function getBrands() {
        return $this->hasOne(Brands::className(), ['id' => 'brand_id']);
    }

}