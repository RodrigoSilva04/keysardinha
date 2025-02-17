<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php
?>
<div class="produto-form">

    <?php $form = ActiveForm::begin((['options' => ['enctype' => 'multipart/form-data']])); ?>


    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descricao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'preco')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imagemFile')->fileInput() ?>

    <?= $form->field($model, 'datalancamento')->textInput() ?>

    <?= $form->field($model, 'stockdisponivel')->textInput() ?>


    <?= $form->field($model, 'categoria_id')->dropDownList(
        \yii\helpers\ArrayHelper::map($categorias, 'id', 'nome'),
        ['prompt' => 'Selecione uma Categoria']
    ) ?>

    <?= $form->field($model, 'desconto_id')->dropDownList(
        \yii\helpers\ArrayHelper::map($descontos, 'id', 'percentagem'),
        ['prompt' => 'Selecione um desconto']
    ) ?>

    <?= $form->field($model, 'iva_id')->dropDownList(
        \yii\helpers\ArrayHelper::map($ivas, 'id', 'taxa'),
        ['prompt' => 'Selecione um iva']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
