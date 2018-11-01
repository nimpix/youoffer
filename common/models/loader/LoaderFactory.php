<?php

namespace common\models\loader;

abstract class LoaderFactory
{
    public abstract function factory();

    public function parserInit()
    {
        $parser = $this->factory();

        return $parser->insertData();
    }
}