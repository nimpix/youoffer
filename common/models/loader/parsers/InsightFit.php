<?php

namespace common\models\loader\parsers;

use common\models\loader\Parser;
use SimpleXMLElement;
use Yii;

class InsightFit implements Parser
{
    public $file;
    private $_xml;
    private $_imagedir;

    public function __construct($file, $imagedir)
    {
        $this->file = $file;
        $this->_imagedir = $imagedir;
    }

    public function Parsing()
    {
       $data = file_get_contents($this->file);
       $this->_xml = new SimpleXMLElement($data);
       $space = $this->_xml->getNamespaces(true);

        foreach($this->_xml->channel->item as $goods) {

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
            $g_id =$g->id;

            $dir_path = Yii::getAlias('@xml');
            $images_path = Yii::getAlias('@images');

           try{
               copy($g_image_link, $dir_path .'/' . $this->_imagedir .'/'. basename($g_image_link));
           }catch (yii\base\ErrorException $e){
               $image_url =  $images_path . 'noImage.jpg';
           }



//            $pic   = "images_xml/".__FUNCTION__."_".$id_postavshik."/".basename($g_image_link);
//            $brand = getOrInsertBrand($g->seria);
//            $price = intval(trim($g_price));
//            $status = "";
//            if ($status==""){$status ="Неизвестно";}
//
//            if ($g_descr==""){$g_descr ="Описание отсутствует";}
//            $arr_prm = array(
//                "name" 		  	   => $g_title,
//                "description" 	   => $g_descr,
//                "articul_post"	   => $g_id,
//                "articul_in"  	   => $g_id,
//                "tbl_status_goods" => $status,
//                "tbl_postavshik"   => $id_postavshik,
//                "tbl_brand"		   => $brand,
//                "price_r_rub"	   => $price,
//                "photo"			   => $image_url,
//                "id_in_xml"		   => $g_id,
//                "this_manuel_load" => "0"
//
//            );
//
//
//            //if($cnt_upl>=15){break;}
//            insertOrUpdateGoods($arr_prm);
//            $cnt_upl++;
        }
    }

    public function InsertData()
    {

    }
}

//foreach($xml->shop->offers->offer as $goods)#read goods
//{
//
//    $g_image_link = explode(",", $goods->picture);
//    $g_image_link = $g_image_link[0];
//
//    if($g_image_link == "")
//    {
//        $pic ="images_xml/no_picture.jpg";
//    }
//
//    copy($g_image_link, $_SERVER['DOCUMENT_ROOT']."/images_xml/".__FUNCTION__."_".$id_postavshik."/".basename($g_image_link));
//    $pic   = "images_xml/".__FUNCTION__."_".$id_postavshik."/".basename($g_image_link);
//
//
//    $name  = $goods->name;
//    $brand = getOrInsertBrand($goods->vendor);
//    $descr = $goods->description;
//    $price = intval(trim($goods->price));
//    $id_in_xml = "";
//    #echo $id_in_xml;
//
//    foreach ($goods->param as $param) {
//        switch((string) $param['name']) {
//            case 'Артикул':
//                $id_in_xml = $param;
//                break;
//        }
//    }
