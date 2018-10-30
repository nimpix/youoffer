<?php

namespace backend\models\products;

use yii\db\ActiveRecord;
use backend\models\merchants\Merchant;
use backend\models\brands\Brands;
use backend\models\catalog\sections\Sections;

class Products extends ActiveRecord
{
    public function getMerchant()
    {
        return $this->hasOne(Merchant::className(), ['id' => 'merchant_id']);
    }

    public function getBrands()
    {
        return $this->hasOne(Brands::className(), ['id' => 'brand_id']);
    }

    public function getSections()
    {
        return $this->hasMany(Sections::className(), ['id' => 'sections_id'])
            ->viaTable('products_sections', ['products_id' => 'id']);
    }
}