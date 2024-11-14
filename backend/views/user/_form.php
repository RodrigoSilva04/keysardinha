<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $userModel */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <h1>Update User: <?= Html::encode($userModel->username) ?></h1>

    <hr>

    <?php $form = ActiveForm::begin(); ?>

    <!-- Dropdown para mudar a role -->
    <?= $form->field($userModel, 'role')->dropDownList(
        ['admin' => 'Admin', 'client' => 'Client', 'collaborator' => 'Collaborator'],  // As roles disponíveis
        [
            'prompt' => 'Select Role',  // Valor para quando a role não estiver definida
            'options' => [
                $userModel->role => ['Selected' => true],  // Seleciona a role atual do usuário
            ],
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
