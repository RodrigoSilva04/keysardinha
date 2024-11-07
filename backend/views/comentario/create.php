<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Comentario $model */

$this->title = 'Create Comentario';
$this->params['breadcrumbs'][] = ['label' => 'Comentarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comentario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
