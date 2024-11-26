<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $userModel */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Create New User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?php $form = ActiveForm::begin(); ?>

    <!-- Campo para o username -->
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <!-- Campo para o email -->
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <!-- Campo para a password -->
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <!-- Dropdown para definir a role -->
    <?= $form->field($model, 'role')->dropDownList(
        ['admin' => 'Admin', 'client' => 'Client', 'collaborator' => 'Collaborator'],
        ['prompt' => 'Select Role']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>