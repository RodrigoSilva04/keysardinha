<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Desconto $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="desconto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'datainicio')->textInput() ?>

    <?= $form->field($model, 'datafim')->textInput() ?>

    <?= $form->field($model, 'ativo')->textInput() ?>

    <?= $form->field($model, 'desconto')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
