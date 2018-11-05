<?php

namespace backend\models\products;

use yii\helpers\FileHelper;
use backend\models\catalog\sections\Sections;
use Yii;
use backend\models\currency\Currency;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use backend\models\products\Products;
use backend\models\merchants\Merchant;
use backend\models\products\ProductProvider;
use yii\helpers\ArrayHelper;
use backend\models\products\CategoryList;
use  backend\models\brands\Brands;
use backend\models\products\MerchantsList;
use backend\models\products\Params;
use yii\web\UploadedFile;
use yii\base\Model;

class ProductInserter extends Model
{
    public $name;
    public $brand_list;
    public $merch_list;
    public $descr;
    public $articul;
    public $price_roznica;
    public $price_opt;
    public $status;
    public $waiting;
    public $weight;
    public $amount;
    public $image;
    public $size;
    public $url;
    public $catdrop;
    public $brandrop;
    public $merchdrop;
    public $category_list;

    public function rules()
    {
        return [
            [['name', 'brand_list', 'merch_list', 'price_roznica'], 'required'],
            ['descr', 'safe'],
            ['name', 'string', 'min' => 3],
            ['category_list', 'safe'],
            ['brand_list', 'string'],
            ['merch_list', 'string'],
            ['articul', 'string'],
            ['price_roznica', 'integer'],
            ['price_opt', 'integer'],
            ['status', 'string'],
            ['waiting', 'string'],
            ['weight', 'string'],
            ['amount', 'integer'],
            ['size', 'string'],
            ['image', 'file', 'extensions' => ['png', 'jpeg', 'gif', 'jpg'],'maxSize' => 512*512],
        ];
    }

    public function attributeLabels()
    {
        return
            [
                'name' => 'Название'
            ];
    }

    public function insertUserData()
    {
        $prod = new Products();

        $root = Yii::getAlias('@images');
        $path = $root . '/uploads/images/';
        FileHelper::createDirectory($path, 0775, true);

        if(!empty($this->image) && $this->image->size !== 0) {
            $this->image->saveAs($path . $this->image->baseName . '.' . $this->image->extension);
            $this->url = '/uploads/images/' . $this->image->baseName . '.' . $this->image->extension;
        }else{
            $this->url = '/uploads/images/noimage.jpeg';
        }

        /**
         * Сохраняем
         */
        $prod->name = $this->name;
        $prod->description = $this->descr;
        $prod->brand_id = $this->brand_list;
        $prod->merchant_id = $this->merch_list;
        $prod->description = $this->descr;
        $prod->articul = $this->articul;
        $prod->image = $this->url;
        $prod->price_roznica = $this->price_roznica;
        $prod->price_opt = $this->price_opt;
        $prod->status = $this->status;
        $prod->waiting = $this->waiting;
        $prod->weight = $this->weight;
        $prod->amount = $this->amount;
        $prod->size = $this->size;

        if ($prod->save()) {
            $response = 'Успешно обновлено';
        }

        foreach ($this->category_list as $cat) {
            $sections = Sections::findOne($cat);
            try {
                $prod->link('sections', $sections);
                $response = 'Категория успешно добавлена';
            } catch (yii\base\InvalidArgumentException $e) {
                $response = 'Relation is not added ' . $e->getMessage();
            }
        }

        return $response;
    }

    public function updateUserData()
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;

        $post = Yii::$app->request->post();

        $prod = Products::findOne($post['id']);

        $root = Yii::getAlias('@images');
        $path = $root . '/uploads/images/';
        FileHelper::createDirectory($path, 0775, true);

        if(!empty($this->image) && $this->image->size !== 0) {
            $this->image->saveAs($path . $this->image->baseName . '.' . $this->image->extension);
            $this->url = '/uploads/images/' . $this->image->baseName . '.' . $this->image->extension;
        }else{
            $this->url = '/uploads/images/noimage.jpeg';
        }

        /**
         * Сохраняем
         */
        $prod->name = $post['name'];
        $prod->brand_id = $post['brand_list'];
        $prod->merchant_id = $post['merch_list'];
        $prod->description = $post['descr'];
        $prod->articul = $post['articul'];
        $prod->image = $this->url; 
        $prod->price_roznica = $post['price_roznica'];
        $prod->price_opt = $post['price_opt'];
        $prod->status = $post['status'];
        $prod->waiting = $post['waiting'];
        $prod->weight = $post['weight'];
        $prod->amount = $post['amount'];
        $prod->size = $post['size'];

        if ($prod->save()) {
            $response->data = 'Успешно обновлено';
        }

        return $response;
    }

    public function Uplinks()
    {

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $get = Yii::$app->request->get();

        /**
         * Обновляем связи
         */

        $prod = Products::findOne($get['id']);

        $sections = Sections::findOne($get['cat_id']);

        try {
            $prod->link('sections', $sections);
            $response->data = 'Категория успешно добавлена';
        } catch (yii\base\InvalidArgumentException $e) {
            $response->data = 'Категория не добавлена ошибка ' . $e->getMessage();
        }

        return $response;
    }

    public function Dellinks()
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $get = Yii::$app->request->get();

        $prod = Products::findOne($get['id']);


        /**
         * Удаляем связи
         */

        $sectionsdel = Sections::findOne($get['cat_id']);

        try {
            $prod->unlink('sections', $sectionsdel, true);
            $response->data = 'Категория успешно удалена';
        } catch (yii\base\InvalidArgumentException $e) {
            $response->data = 'Категория не удалена ошибка ' . $e->getMessage();
        }

        return $response;
    }

    public function getCatdrop()
    {
        $section = new Sections();
        $data = $section->find()->asArray()->all();
        $data = ArrayHelper::map($data, 'id', 'name');
        return $data;
    }

    public function getBrandrop()
    {
        $brand = new Brands();
        $data = $brand->find()->asArray()->all();
        $data = ArrayHelper::map($data, 'id', 'name');
        return $data;
    }

    public function getMerchdrop()
    {
        $brand = new Merchant();
        $data = $brand->find()->asArray()->all();
        $data = ArrayHelper::map($data, 'id', 'name');
        return $data;
    }



//    public function save(){
//        parent::save();
//    }
}