<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Cupao $model */

$this->title = 'Update Cupao: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cupaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cupao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
