<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


$form = ActiveForm::begin([
    'id' => 'detailed',
    'options' => ['class' => ''],
]) ?>
<?= $form->field($mainform, 'name')->Input('name')->label('Название') ?>
<?= $form->field($mainform, 'descr')->textarea(['rows' => '6'])->label('Описание') ?>
<?= $form->field($mainform, 'category_list')->dropDownList($mainform->Catdrop,
    [
        'multiple' => 'multiple',
        'class' => 'chosen-select input-md ',
        'enableAjaxValidation' => true,
    ]
)->label("Категории"); ?>

<?= $form->field($mainform, 'brand_list')->dropDownList($mainform->Brandrop,
    [
        'class' => 'chosen-select input-md',
    ]
)->label("Бренды"); ?>

<?= $form->field($mainform, 'merch_list')->dropDownList($mainform->Merchdrop,
    [
        'class' => 'chosen-select input-md',
    ]
)->label("Поставщики"); ?>
<?= $form->field($mainform, 'image')->fileInput()->label('Изображение') ?>

<? foreach ( $inputs as $item) {
   echo  $form->field($mainform, $item['id'])->Input('name')->label($item['name']);
} ?>



<!--    <div class="clearfix"></div>-->
<!--    {{ options_cat | raw }}-->
<!---->


<div class="form-group">
    <div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary send-data']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>

