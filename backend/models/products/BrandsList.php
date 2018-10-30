<?php

namespace backend\models\products;

use  backend\models\brands\Brands;
use Yii;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use backend\models\currency\Currency;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use backend\models\products\Products;
use backend\models\merchants\Merchant;
use backend\models\products\ProductProvider;
use backend\models\catalog\sections\Sections;
use yii\helpers\ArrayHelper;

class BrandsList
{
    public static function getBrandsList($get)
    {
        $data = Products::find()->with('brands')->where(['=', 'id', $get['id']])->all();
        $mainbrand = ArrayHelper::toArray($data[0]->brands, [Brands::class => ['name','id'],]);

        $brands = new Brands();
        $options = $brands->find()->all();

        $options_data = ArrayHelper::toArray($options, [Brands::class => ['name','id'],]);

        foreach ($options_data as $key => $elem)
        {
            if ($elem['name'] == $mainbrand['name'])
            {
                unset($options_data[$key]);
            }
        }

        $options_html = '';

        foreach ($options_data as $data) {
            $options_html .= '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
        }

        $brandlist = [];


        array_push($brandlist,['default' => $mainbrand['name'],'body' => $options_html,'brand_id' => $mainbrand['id']]);

        return $brandlist;
    }
}