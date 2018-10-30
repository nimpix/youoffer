<?php

namespace backend\models\products;

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


class CategoryList
{
    public static function renderCatList($get)
    {
        $section = new Sections();

        $data = Products::find()->with('sections')->where(['=', 'id', $get['id']])->all();

        $maincat = ArrayHelper::toArray($data[0]->sections, [Sections::class => ['name','id'],]);


        $options = $section->find()->all();

        $options_data = ArrayHelper::toArray($options, [Sections::class => ['name','id'],]);

        foreach ($options_data as $key => $elem)
        {
            if ($elem['name'] == $maincat['name'])
            {
                unset($options_data[$key]);
            }
        }

        $options_html = '';

        foreach ($options_data as $data) {
            $options_html .= '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
        }

        $catlist = [];

        array_push($catlist,['default' => $maincat['name'],'body' => $options_html,'id' => $maincat['id']]);

        return $catlist;
    }
}