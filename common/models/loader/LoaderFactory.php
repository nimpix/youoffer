<?php

namespace common\models\loader;

interface LoaderFactory
{
    public function createParser($name);

}