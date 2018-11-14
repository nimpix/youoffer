<?php

namespace common\models\loader\parsers;

use common\models\loader\LoaderFactory;
use yii\helpers\FileHelper;
use backend\models\merchants\Merchant;
use yii;

class Loader implements LoaderFactory
{
    public $post;
    public $name;
    public $file;
    public $filepath;

    public function createParser($post,$file)
    {
        $merch = new Merchant();
        $merch_arr = $merch->find()->Select(['name'])->where(['=','id', $post['parser-name']])->all();

        $this->name = $merch_arr[0]->name;
        $this->post = $post;
        $this->file = $file;

        $this->getXml();

        switch($this->name){
            case 'InsightFitness': return Yii::createObject(InsightFit::class,[$this->filepath, $this->name, $post['parser-name']]);
            default: throw new yii\base\ErrorException;
        }
    }

    public function getXml()
    {
        $dir_path = Yii::getAlias('@xml');

        $this->name = str_replace(' ', '', $this->name);
        FileHelper::createDirectory($dir_path, 0775, true);
        FileHelper::createDirectory($dir_path .'/' . $this->name, 0775, true);
        FileHelper::createDirectory($dir_path .'/' . $this->name . '/thumbnails', 0775, true);

        $this->filepath = $dir_path . '/' . $this->file->name;


        $this->file->saveAs($this->filepath);
    }
}
