<?php

namespace common\models\loader\parsers;

use common\models\loader\Parser;
use SimpleXMLElement;
use Yii;
use backend\models\brands\Brands;

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
                copy($g_image_link, $dir_path . '/' . $this->_imagedir . '/' . basename($g_image_link));
            } catch (yii\base\ErrorException $e) {
                $image_url = $images_path . 'noImage.jpg';
            }
            array_push($elems,[
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

        $this->InsertData($elems);
    }

    public function InsertData($data)
    {

    }
}
