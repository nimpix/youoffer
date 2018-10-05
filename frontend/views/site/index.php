<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */

$this->title = 'youoffer';
?>


<div class="container-fluid text-center">
    <div class="row">
        <div class="col-xs-12 d-flex flex-wrap flex-row justify-content-center">    
                    <?
                    $form = ActiveForm::begin([
                        'id' => 'main-form',
                        'options' => ['class' => 'form-row'],
                    ]) ?>
                    <div class="col-auto">
                        <?= $form->field($allforms[0], 'name')->textInput(['placeholder' => "Логин"])->label(false); ?>
                    </div>
                    <div class="col-auto">
                        <?= $form->field($allforms[0], 'password')->passwordInput(['placeholder' => "Пароль"])->label(false); ?>
                    </div>   
                        <div class="form-group">
                            <div class="">
                                <input type="hidden" value="BottomForm" name="EntryBottomForm[form_name]">
                                <?= Html::submitButton('Заказать', ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>

                    <?php ActiveForm::end() ?>
                    <div class="clearfix"></div>
                            <div class="col-xs-12">
                            <div class="message"></div>
                    </div>
        </div>
    </div>
</div>

