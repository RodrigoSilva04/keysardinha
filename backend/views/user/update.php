<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $userModel */
/** @var common\models\Utilizadorperfil $perfilModel */

$this->title = 'Update User: ' . $userModel->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $userModel->id, 'url' => ['view', 'id' => $userModel->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'userModel' => $userModel,  // Passando o userModel para o formulário
        'perfilModel' => $perfilModel,  // Passando o perfilModel para o formulário
    ]) ?>

</div>
