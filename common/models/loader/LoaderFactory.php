<?php

namespace common\models\loader;

interface LoaderFactory
{
    public function createParser($post,$file);
    
    public function getXml();
}