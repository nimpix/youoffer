<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
/**
 * Инициализатор RBAC выполняется в консоли php yii rbac/init
 */
class RbacController extends Controller {

    public function actionInit() {
        $auth = Yii::$app->authManager;

        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...

        // Создадим роли админа и редактора новостей
        $admin = $auth->createRole('admin-role');
        $product = $auth->createRole('product-role');
        $manager = $auth->createRole('manager-role');


        // запишем их в БД
        $auth->add($admin);
        $auth->add($product);
        $auth->add($manager);

        //админ умеет все
        $auth->addChild($admin, $product);
        $auth->addChild($admin, $manager);

        $auth->addChild($product,$manager);


        // Назначаем роль admin пользователю с ID 1
        $auth->assign($admin, 1);

        // Назначаем роль editor пользователю с ID 2
        $auth->assign($product, 2);
        $auth->assign($manager, 4);
    }
}