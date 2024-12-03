<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Chavedigital $model */

$this->title = 'Update Chavedigital: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chavedigitals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chavedigital-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'produtos' => $produtos,
    ]) ?>

</div>
