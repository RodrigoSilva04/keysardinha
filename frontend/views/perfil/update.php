<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $user */
/** @var common\models\Utilizadorperfil $perfil */

$this->title = 'Editar Perfil';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perfil-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'perfil' => $perfil,
        'user' => $user,
    ]) ?>


