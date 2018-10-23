<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1>Доступ запрещен</h1>

    <div class="alert alert-danger">
        Запрет на просмотр
    </div>

    <p>
        Страница недоступна для текущего пользователя.
    </p>
    <p>
       Пожалуйста, свяжитесь с администратором.
    </p>

</div>
