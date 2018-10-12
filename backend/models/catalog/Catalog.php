<?php

namespace backend\models\catalog;

use backend\models\catalog\sections\Sections;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

//Сделать потом абстрактную фабрику

class Catalog
{

    private $_sections;

    public $sect = [];

    public function __construct()
    {
        $this->_sections = new Sections();
    }

    private function getAllSectionsBranched()
    {
        $roots = Sections::find()->roots()->addOrderBy('tree, lft')->all();


        foreach ($roots as $root) {
            $this->sect[] = [
                'lft' =>$root->lft,
                'rgt' =>$root->rgt,
                'id' => $root->id,
                'name' => $root->name,
                'depth' => $root->depth,
                'items' => self::getTree($root->children()->all())
            ];
        }
        return $this->sect;
    }

    private function getTree($roots, $lft = 0, $rgt = null, $depth = 1)
    {
        $items = [];

        foreach ($roots as $root) {
            if ($root->lft >= $lft + 1 && $root->depth == $depth && ($root->rgt <= $rgt || is_null($rgt))) {
                $items[] = [
                    'lft' =>$root->lft,
                    'rgt' =>$root->rgt,
                    'id' => $root->id,
                    'name' => $root->name,
                    'depth' => $root->depth,
                    'items' => self::getTree($roots, $root->lft, $root->rgt, $root->depth + 1)
                ];
            }
        }
        return $items;
    }

    public function renderList(){
        $tree = self::getAllSectionsBranched();
        return $tree;
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