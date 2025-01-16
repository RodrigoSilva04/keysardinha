<?php

use common\models\Tarefa;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tarefas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarefa-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="">
        <?php foreach ($dataProvider->models as $tarefa): ?>
        <?php $user = $tarefa->user; ?>
        <?php if ($user): // Verificar se o user existe ?>
        <div class="">
            <a href="<?= \yii\helpers\Url::to(['tarefa/view', 'id' => $tarefa->id]) ?>">

            </a>
        </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'descricao',
            'feito',
            'user_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Tarefa $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>
    </div>
</div>
<?php endif; ?>
<?php endforeach; ?>

