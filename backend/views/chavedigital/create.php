<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Chavedigital $model */

$this->title = 'Create Chavedigital';
$this->params['breadcrumbs'][] = ['label' => 'Chavedigitals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chavedigital-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'produtos' => $produtos,
    ]) ?>

</div>
