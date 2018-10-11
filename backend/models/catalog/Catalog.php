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

    public function getAllSectionsBranched($tagOne ='<ul>',$closeOne = '</ul>',$tagTwo = '<li>',$closeTwo = '</li>')
    {
        $roots = Sections::find()->roots()->addOrderBy('tree, lft')->all();

        $config = [
            'tagOne' => $tagOne,
            'closeOne' => $closeOne,
            'tagTwo' => $tagTwo,
            'closeTwo' => $closeTwo,
        ];

        foreach ($roots as $root) {
            $this->sect .= $tagTwo . 'id:' . $root->id . ' ' . $root->name . $tagOne . self::getTree($root->children()->all(), $config) . $closeOne.$closeTwo;
        }

        return $this->sect;

    }

    public static function getTree($categories, $config, $left = 0, $right = null, $lvl = 1)
    {

        $tree = '';

        foreach ($categories as $category) {
            if ($category->lft >= $left + 1 && (is_null($right) || $category->rgt <= $right) && $category->depth == $lvl) {
                $tree .= $config['tagTwo'] . 'id:' . $category->id . ' ' . $category->name . $config['tagOne'] . self::getTree($categories,$config,
                        $category->lft, $category->rgt, $category->depth + 1) . $config['closeOne'].$config['closeTwo'];
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