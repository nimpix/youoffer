<?php

namespace backend\models\catalog\sections\types\block;

use backend\models\catalog\sections\types\block\Block;
use yii\base\BaseObject;
use backend\models\catalog\sections\Sections;

class Select extends BaseObject implements Block
{
    public function formData($request)
    {
        $tree = new Sections();

        $res = $tree->find()->all();

        $result = '';

        foreach ($res as $item) {
            $result .= '<option>' . $item->name . '</option>';
        }

        return $result;
    }
}