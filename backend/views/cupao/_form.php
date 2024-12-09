<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Cupao $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="cupao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'datavalidade')->textInput() ?>

    <?= $form->field($model, 'desconto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ativo')->textInput() ?>

    <?= $form->field($model, 'pontosnecessarios')->textInput() ?>

    <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
