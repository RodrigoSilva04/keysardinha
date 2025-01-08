<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Chavedigital $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php
$this->registerJsFile('@web/js/gerarkey.js', [
    'depends' => [\yii\web\JqueryAsset::class], // Certifica-se de que o jQuery é carregado antes
]);
?>

<div class="chavedigital-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'chaveativacao')->textInput(['maxlength' => true]) ?>

    <button type="button" id="btn-gerarkey" class="btn btn-secondary">Gerar chave digital automatica</button>

    <?= $form->field($model, 'estado')->dropDownList([ 'usada' => 'Usada', 'nao usada' => 'Não usada', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'produto_id')->dropDownList(
        \yii\helpers\ArrayHelper::map($produtos, 'id', 'nome'),
        ['prompt' => 'Selecione um produto']
    ) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
