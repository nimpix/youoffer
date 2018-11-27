<?
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use backend\models\templates\TemplatesValidator;

?>

<h2>Изменение шаблона</h2>
<?=$error?>
<?

$form = ActiveForm::begin([
    'id' => 'templates-update',
    'options' => ['class' => ''],
]) ?>
<? $model = new TemplatesValidator();
   $model->getTemplateData();
?>
<?= $form->field($model, 'name')->Input('name')->label('Название') ?>
<?= $form->field($model, 'template')->label('Шаблон')->widget(CKEditor::className(),[
    'editorOptions' => ElFinder::ckeditorOptions('elfinder',[])
]);?>
<?= $form->field($model, 'updater')->hiddenInput(['value'=>true])->label(false); ?>

<div class="form-group">
    <div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Изменить', ['class' => 'btn btn-primary send-data']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>
<a href="/backend/web/templates/" class="btn btn-success">Назад</a>
