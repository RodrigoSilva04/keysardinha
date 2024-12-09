<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Favoritos $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="favoritos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'utilizadorperfil_id')->textInput() ?>

    <?= $form->field($model, 'produto_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
