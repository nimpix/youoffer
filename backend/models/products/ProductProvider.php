<?php

namespace backend\models\products;

use yii\base\Model;


class ProductProvider extends Model
{
    private $product;
    public $products;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->product = new Products;
    }

    public function getProducts()
    {
        return $this->product->find()->joinWith('merchant')->all();
    }
}