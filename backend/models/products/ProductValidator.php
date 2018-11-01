<?php

namespace backend\models\products;

use Yii;
use backend\models\currency\Currency;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use backend\models\products\Products;
use backend\models\merchants\Merchant;
use backend\models\products\ProductProvider;
use backend\models\catalog\sections\Sections;
use yii\helpers\ArrayHelper;
use backend\models\products\CategoryList;
use backend\models\products\BrandsList;
use backend\models\products\MerchantsList;
use backend\models\products\Params;
use yii\web\UploadedFile;
use yii\base\Model;

class ProductValidator extends Model
{
    public $name;

    public function insertUserData()
    {
        $prod = new Products();

        $response = [];
        /**
         * Сохраняем
         */
        $prod->name = $this->name;
//        $prod->brand_id = $post['brand-list'];
//        $prod->merchant_id = $post['merch-list'];
//        $prod->description = $post['descr'];
//        $prod->articul = $post['articul'];
//        $prod->image = ''; //image
//        $prod->price_roznica = $post['price_roznica'];
//        $prod->price_opt = $post['price_opt'];
//        $prod->status = $post['status'];
//        $prod->waiting = $post['waiting'];
//        $prod->weight = $post['weight'];
//        $prod->amount = $post['amount'];
//        $prod->size = $post['size'];

        if ($prod->save()) {
            $response['data'] = 'Успешно обновлено';
        }

//        $cat_list = [];
//        foreach ($post as $key => $value) {
//            if (strstr($key, 'category-list')) {
//                array_push($cat_list, $value);
//            }
//        }
//
//        foreach ($cat_list as $cat) {
//            $sections = Sections::findOne($cat);
//            try {
//                $prod->link('sections', $sections);
//                $response['data'] = 'Категория успешно добавлена';
//            } catch (yii\base\InvalidArgumentException $e) {
//                $response['data'] = 'Relation is not added ' . $e->getMessage();
//            }
//        }
        return $response;
    }
}