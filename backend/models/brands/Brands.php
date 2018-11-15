<?php

namespace backend\models\brands;

use yii\db\ActiveRecord;
use backend\models\merchants\Merchant;

class Brands extends ActiveRecord
{
    public function getMerchant() {
        return $this->hasMany(Merchant::className(), ['id' => 'merchant_id'])
            ->viaTable('brands_merchant', ['brands_id' => 'id']);
    }
}