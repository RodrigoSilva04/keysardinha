<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Fatura $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fatura-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'datafatura')->textInput() ?>

    <?= $form->field($model, 'totalciva')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subtotal')->textInput() ?>

    <?= $form->field($model, 'valor_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->dropDownList([ 'pago' => 'Pago', 'pendente' => 'Pendente', 'cancelado' => 'Cancelado', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'descontovalor')->textInput() ?>

    <?= $form->field($model, 'datapagamento')->textInput() ?>

    <?= $form->field($model, 'utilizadorperfil_id')->textInput() ?>

    <?= $form->field($model, 'metodopagamento_id')->textInput() ?>

    <?= $form->field($model, 'desconto_id')->textInput() ?>

    <?= $form->field($model, 'cupao_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
