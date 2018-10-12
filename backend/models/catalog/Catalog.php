<?php

namespace backend\models\catalog;

use backend\models\catalog\sections\SectionsTemplateRenderer;
use backend\models\catalog\sections\Sections;

class Catalog
{
    public $catalogRender;

    public function __construct()
    {
        $this->catalogRender = new SectionsTemplateRenderer();
    }

    public function renderTemplateList()
    {
       $result = $this->catalogRender->renderList();

       return $result;
    }

    public function renderTemplateHierarchy()
    {
        $result = $this->catalogRender->renderHierarchy();

        return $result;
    }

    public function renderTemplateSelectList()
    {
        $result = $this->catalogRender->renderSelectList();

        return $result;
    }

    public function addNewBranch($conf)
    {
        if ($conf['branch']) {
            $branch = new Sections(['name' => $conf['name']]);
            $parent = Sections::findOne(['name' => $conf['branch']]);
            $branch->appendTo($parent);
        } else {
            $branch = new Sections(['name' => $conf['name']]);
            $branch->makeRoot();
        }

        return 'Ветка {$branch} успешно добавлена';
    }
}