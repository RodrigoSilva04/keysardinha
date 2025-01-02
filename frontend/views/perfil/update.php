<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $user */
/** @var common\models\Utilizadorperfil $perfil */

$this->title = 'Editar Perfil';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perfil-update d-flex flex-column align-items-center justify-content-center" style="min-height: 100vh;">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class=" row justify-content-center w-100">
        <?php $form = ActiveForm::begin(); ?>

        <h3>Dados de Utilizador</h3>
        <?= $form->field($user, 'username')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
        <?= $form->field($user, 'email')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>

        <br><br>

        <h3>Dados do Perfil</h3>
        <?= $form->field($perfil, 'nome')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
        <?= $form->field($perfil, 'dataregisto')->textInput(['maxlength' => true, 'readonly' => true, 'class' => 'form-control']) ?>
        <?= $form->field($perfil, 'pontosacumulados')->textInput(['maxlength' => true, 'readonly' => true, 'class' => 'form-control']) ?>

        <div class="form-group text-center">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

