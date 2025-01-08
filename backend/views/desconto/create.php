<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Desconto $model */

$this->title = 'Create Desconto';
$this->params['breadcrumbs'][] = ['label' => 'Descontos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="desconto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
