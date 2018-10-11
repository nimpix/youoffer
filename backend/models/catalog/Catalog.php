<?php

namespace backend\models\catalog;

use backend\models\catalog\sections\Sections;

class Catalog
{

    private $_sections;

    public $sect = '';

    public function __construct()
    {
        $this->_sections = new Sections();
    }

    public function getAllSections (){

    }

    public function getAllSectionsBranched()
    {
        $roots = Sections::find()->roots()->addOrderBy('tree, lft')->all();

        foreach ($roots as $root) {
            $this->sect .= '<li>' . 'id:' . $root->id . ' ' . $root->name . '<ul>' . self::getTree($root->children()->all()) . '</ul></li>';
        }

        return $this->sect;

    }

    public static function getTree($categories, $left = 0, $right = null, $lvl = 1)
    {

        $tree = '';

        foreach ($categories as $category) {
            if ($category->lft >= $left + 1 && (is_null($right) || $category->rgt <= $right) && $category->depth == $lvl) {
                $tree .= '<li>' . 'id:' . $category->id . ' ' . $category->name . '<ul>' . self::getTree($categories,
                        $category->lft, $category->rgt, $category->depth + 1) . '</ul></li>';
            }
        }

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