<?php

namespace common\models\loader;

use Yii;
use backend\models\brands\Brands;
use yii\helpers\ArrayHelper;
use backend\models\products\Products;

abstract class Parser
{
    public $file;
    public $id;
    public $imagedir;

    public function __construct($file, $imagedir, $id)
    {
        $this->file = $file;
        $this->id = $id;
        $this->imagedir = $imagedir;
        $this->brands_table = new Brands();
    }

    abstract public function Parsing();

    public function getImage($url,$image)
    {
      $file = file_get_contents($image);
      file_put_contents($url,$file);
    }

    public function InsertBrand($data)
    {

        $brand_table = $this->brands_table;

        $new_brands = [];

        //Getting all new brands with no doubles

        foreach ($data as $elem) {
            $brand = $elem['tbl_brand'];
            $brand = $brand->__toString();

            if (!ArrayHelper::isIn($brand, $new_brands)) {
                array_push($new_brands, $brand);
            }
        }

        foreach ($new_brands as $value) {
            if (empty($brand_table->find()->Select('name')->asArray()->where(['=', 'name', $value])->all())) {
                $new_table_brand = $this->brands_table;
                $new_table_brand->name = $value;
                $new_table_brand->save();
            }
        }
    }

    public function InsertOrUpdate($data)
    {
        $products = new Products();

        foreach ($data as $val) {
            $brand_id = $this->brands_table->find()->Select(['id'])->where(['=', 'name', $val['tbl_brand']->__toString()])->asArray()->all();

            $brand_id = ArrayHelper::getValue($brand_id, function ($brand_id) {
                return intval($brand_id[0]['id']);
            });

            $prod_searched = $products->find()->where(['=', 'articul', $val['articul']])->all();

            if (empty($prod_searched)) {
                $products = new Products();
                $products->name = $val['name']->__toString();
                $products->description = $val['description'];
                $products->articul = $val['articul']->__toString();
                $products->status = $val['status_goods'];
                $products->image = $val['photo'];
                $products->price_opt = $val['price'];
                $products->price_roznica = $val['price'] * 2;
                $products->merchant_id = $val['postavshik'];
                $products->brand_id = $brand_id;
                $products->save();
            } else {
                $products = $prod_searched[0];
                $products->name = $val['name']->__toString();
                $products->description = $val['description'];
                $products->articul = $val['articul']->__toString();
                $products->status = $val['status_goods'];
                $products->image = $val['photo'];
                $products->price_opt = $val['price'];
                $products->price_roznica = $val['price'] * 2;
                $products->merchant_id = $val['postavshik'];
                $products->brand_id = $brand_id;
                $products->update();
            };
        }


    }
}