<?

namespace backend\models;

use common\models\User;
use yii\data\ActiveDataProvider;
use backend\templates\Templates;

class Users extends User
{
    public static function getUsersList(){
        $users_data = new ActiveDataProvider([
            'query' => self::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $users_data;
    }

    public function getTemplates(){
        return $this->hasMany(Templates::className(), ['id' => 'templates_id'])
            ->viaTable('user_templates', ['user_id' => 'id']);
    }
}