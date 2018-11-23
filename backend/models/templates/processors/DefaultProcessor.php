<?php

namespace models\templates\processors\templates;

use templates\processors\Templates;

class DefaultProcessor extends Templates
{
    public $post;
    public $name;

    public function __construct($post,$name)
    {
        $this->post = $post;
        $this->name = $name;
        parent::__construct();
    }

    public function getData(){
        //return self::find()->asArray->all();
    }
}