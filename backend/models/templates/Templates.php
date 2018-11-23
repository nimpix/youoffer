<?php

namespace backend\templates;

use yii\db\ActiveRecord;
use backend\models\Users;

class Templates extends ActiveRecord
{
    public function getUsers() {
        return $this->hasMany(Users::className(), ['id' => 'user_id'])
            ->viaTable('user_templates', ['templates_id' => 'id']);
    }
}