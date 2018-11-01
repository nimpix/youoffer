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

class MerchantsList extends Merchant
{
    public static function getMerchantsList($get = [])
    {
        $data = Products::find()->with('merchant')->where(['=', 'id', $get['id']])->all();
        $mainmerch = ArrayHelper::toArray($data[0]->merchant, [Merchant::class => ['name','id'],]);

        $merchs = new Merchant();
        $options = $merchs->find()->all();

        $options_data = ArrayHelper::toArray($options, [Brands::class => ['name','id'],]);

        foreach ($options_data as $key => $elem)
        {
            if ($elem['name'] == $mainmerch['name'])
            {
                unset($options_data[$key]);
            }
        }

        $options_html = '';

        foreach ($options_data as $data) {
            $options_html .= '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
        }

        $merchlist = [];


        array_push($merchlist,['default' => $mainmerch['name'],'body' => $options_html,'merch_id' => $mainmerch['id']]);

        return $merchlist;
    }
}