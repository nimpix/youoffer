<?php

namespace common\models\loader\parsers;

use common\models\loader\Parser;
use SimpleXMLElement;
use Yii;
use backend\models\brands\Brands;
use yii\helpers\ArrayHelper;
use backend\models\products\Products;


class InsightFit implements Parser
{
    public $file;
    public $id;
    private $_xml;
    private $_imagedir;

    public function __construct($file, $imagedir, $id)
    {
        $this->file = $file;
        $this->id = $id;
        $this->_imagedir = $imagedir;
        $this->brands_table = new Brands();
    }

    public function Parsing()
    {
        $data = file_get_contents($this->file);
        $this->_xml = new SimpleXMLElement($data);
        $space = $this->_xml->getNamespaces(true);

        $elems = [];
        foreach ($this->_xml->channel->item as $goods) {

            $g = $goods->children($space["g"]);
            $image_link = 'image-link';
            $g_image_link = $g->$image_link;
            $g_image_link = explode(",", $g_image_link);
            $g_image_link = $g_image_link[0];
            $g_title = $g->title;
            $g_seria = $g->seria;
            $g_descr = $g->description;
            $g_descr = strip_tags($g_descr);
            $g_price = $g->price;
            $g_id = $g->id;

            $status = "Неизвестно";
            $price = intval(trim($g_price));

            if ($g_descr == "") {
                $g_descr = "Описание отсутствует";
            }

            $dir_path = Yii::getAlias('@xml');
            $images_path = Yii::getAlias('@images');

            try {
                $url = $dir_path . '/' . $this->_imagedir . '/' . basename($g_image_link);
                if (!file_exists($url)) {
                    copy($g_image_link, $url);
                }
            } catch (yii\base\ErrorException $e) {
                $image_url = $images_path . '/noImage.jpg';
            }

            array_push($elems, [
                "name" => $g_title,
                "description" => $g_descr,
                "articul" => $g_id,
                "status_goods" => $status,
                "postavshik" => $this->id,
                "tbl_brand" => $g_seria,
                "price" => $price,
                "photo" => $image_url,
            ]);
        }

         $this->InsertBrand($elems);
          $this->InsertOrUpdate($elems);


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
        $cnt = 0;
        foreach ($data as $val) {

            if (empty($products->find()->where(['=', 'articul', $val['articul']])->all())) {
                $products = new Products();
                $products->name = $val['name']->__toString();
                $products->description = $val['description'];
                $products->articul = $val['articul']->__toString();
                $products->status = $val['status_goods'];
                $products->image = $val['photo'];
                $products->price_opt = $val['price'];
                $products->price_roznica = $val['price'] * 2;
                $products->merchant_id = $val['postavshik'];
                $products->brand_id = 1;
                $products->save();

                $cnt++;
            };
            if ($cnt == 10) {
                break;
            }
        }


    }
}
