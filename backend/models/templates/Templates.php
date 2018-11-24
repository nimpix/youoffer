<?php

namespace backend\models\templates;

use yii\db\ActiveRecord;
use backend\models\Users;

class Templates extends ActiveRecord implements Template
{
    public function getUsers() {
        return $this->hasMany(Users::className(), ['id' => 'user_id'])
            ->viaTable('user_templates', ['templates_id' => 'id']);
    }
}