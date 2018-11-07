<?php

namespace common\models\loader\parsers;

use common\models\loader\LoaderFactory;

class Loader implements LoaderFactory
{
    public function createParser($name)
    {
        switch($name){
            case 'Insight Fitness':  return new InsightFit();
        }
    }
}