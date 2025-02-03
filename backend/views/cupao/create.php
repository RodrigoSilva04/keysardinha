<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Cupao $model */

$this->title = 'Create Cupao';
$this->params['breadcrumbs'][] = ['label' => 'Cupaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cupao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>