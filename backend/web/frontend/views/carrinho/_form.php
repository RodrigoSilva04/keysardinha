<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Carrinho $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="carrinho-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'data_criacao')->textInput() ?>

    <?= $form->field($model, 'cupao_id')->textInput() ?>

    <?= $form->field($model, 'utilizadorperfil_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
