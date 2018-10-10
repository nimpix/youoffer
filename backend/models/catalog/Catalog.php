<?php

namespace backend\models\catalog;

use backend\models\catalog\sections\Sections;

class Catalog
{

    private $_sections;

    public $sect = [];

    public function __construct()
    {
        $this->_sections = new Sections();
    }

    public function getAllSections()
    {
        $this->sect = $this->_sections->find()->all();

        return $this->sect;
    }

    public function addNewBranch($conf)
    {
        if($conf['branch']){
           $branch = new Sections(['name' => $conf['name']]);
           $parent = Sections::findOne(['name' => $conf['branch']]);
           $branch->appendTo($parent);
        }else{
            $branch = new Sections(['name' => $conf['name']]);
            $branch->makeRoot();
        }


        
        return 'Ветка {$branch} успешно добавлена';
    }
}