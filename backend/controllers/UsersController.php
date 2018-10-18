<?
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Users;
use yii\grid\GridView;
use common\models\User;
use yii\helpers\Html;

/**
 * Users controller
 */
class UsersController extends Controller
{
    private $_user;

    public function actionIndex()
    {
        $users_data = Users::getUsersList();

        $grid = GridView::widget([
            'dataProvider' => $users_data,
            'columns' => [
                [
                    'attribute' => 'id',
                    'format' => 'text',
                    'label' => 'id',
                    'options' => ['width' => '10'],
                    'contentOptions' => ['class' => 'val-id'],
                ],
                [
                    'attribute' => 'username',
                    'format' => 'text',
                    'label' => 'Имя',
                    'options' => ['width' => '70'],
                    'contentOptions' => ['class' => 'val-name'],
                ],
                [
                    'attribute' => 'status',
                    'format' => 'text',
                    'label' => 'Доступ',
                    'options' => ['width' => '50'],
                    'contentOptions' => ['class' => 'val-status'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'delete') {
                            return \yii\helpers\Url::toRoute(['users/delete', 'id' => $model['id']]);
                        }
                    },
                    'header' => 'Действия',
                    'options' => ['width' => '30'],
                    'headerOptions' => ['style' => 'color:#337ab7'],
                    'buttons' => [
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="fas fa-ban"></span>', $url, [
                                'title' => 'Удалить',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => 'Вы уверены, что хотите удалить пользователя?',
                                ]
                            ]);
                        },
                    ],
                ],
            ],
        ]);

        return $this->render('index.twig', ['grid' => $grid]);
    }

    public function actionAdd(){

        $this->_user = new User();
        $request = Yii::$app->request->get();

        $this->_user->username = $request['login'];
        $this->_user->email = $request['mail'];
        $this->_user->setPassword($request['password']);
        $this->_user->generateAuthKey();

        return $this->_user->save() ? $this->redirect(['users/index', ''], 301) : 'Не добавился. Для уточнения информации свяжитесь с администратором';
    }

    public function actionDelete(){
        $uid = Yii::$app->request->get('id');
//        $user = new User();
//        $users = $user->find()->where(['=','id', $uid])->all();

        return User::deleteAll(['=','id', $uid]) ? $this->redirect(['users/index', ''], 301) : 'Не удалился. Для уточнения информации свяжитесь с администратором';
    }
}