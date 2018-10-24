<?php

namespace backend\models\catalog\sections\types;

use backend\models\catalog\sections\Sections;


abstract class SectionsFactory
{
    abstract public function factory();

    public function getAllSectionsBranched()
    {
        $roots = Sections::find()->roots()->addOrderBy('tree, lft')->all();


        foreach ($roots as $root) {
            $this->sect[] = [
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
                    'id' => $root->id,
                    'name' => $root->name,
                    'depth' => $root->depth,
                    'items' => self::getTree($roots, $root->lft, $root->rgt, $root->depth + 1)
                ];
            }
        }
        return $items;
    }
}