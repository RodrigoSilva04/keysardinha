<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Utilizadorperfil $perfil */
/** @var common\models\User $user */

$this->title = 'Meu Perfil';
?>
<div class="perfil-index d-flex flex-column align-items-center justify-content-center" style="min-height: 100vh;">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class=" row justify-content-center w-100">
        <h3>Dados de Utilizador</h3>
        <p><strong>Username:</strong> <?= Html::encode($user->username) ?></p>
        <p><strong>Email:</strong> <?= Html::encode($user->email) ?></p>
    </div>

    <br><br>

    <div class=" row justify-content-center w-100">
        <h3>Dados do Perfil</h3>
        <p><strong>Nome:</strong> <?= Html::encode($perfil->nome) ?></p>
        <p><strong>Data de Registo:</strong> <?= Html::encode($perfil->dataregisto) ?></p>
        <p><strong>Pontos Acumulados:</strong> <?= Html::encode($perfil->pontosacumulados) ?></p>
    </div>

    <br>

    <p><?= Html::a('Editar Perfil', ['update'], ['class' => 'btn btn-primary']) ?></p>
</div>