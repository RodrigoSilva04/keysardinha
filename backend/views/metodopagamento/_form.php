<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Metodopagamento $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="metodopagamento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nomemetodopagamento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descricao')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
