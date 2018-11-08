<?php

namespace common\models\loader\parsers;

use common\models\loader\Parser;
use SimpleXMLElement;
use Yii;
use backend\models\brands\Brands;
use yii\helpers\ArrayHelper;
use backend\models\products\Products;


class InsightFit extends Parser
{
    public $file;
    public $id;
    private $_xml;
    private $_brand_ids = [];
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

            $url = $dir_path . '/' . $this->_imagedir . '/' . basename($g_image_link);

            try{
                $image_url = '/uploads/xml/' . $this->_imagedir . '/' . basename($g_image_link);
                $this->getImage($url,$g_image_link);
            }catch (yii\base\ErrorException $e){
                $image_url = '/uploads/images/noImage.jpg';
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
}
