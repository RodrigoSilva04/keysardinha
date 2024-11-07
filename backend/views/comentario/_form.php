<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Comentario $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="comentario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'avaliacao')->textInput() ?>

    <?= $form->field($model, 'datacriacao')->textInput() ?>

    <?= $form->field($model, 'produto_id')->textInput() ?>

    <?= $form->field($model, 'utilizadorperfil_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
