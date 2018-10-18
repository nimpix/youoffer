<?

namespace backend\models;

use common\models\User;
use yii\data\ActiveDataProvider;


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
}