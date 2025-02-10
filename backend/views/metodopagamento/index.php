<?php

use common\models\Metodopagamento;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Metodopagamentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metodopagamento-index">

    <p>
        <?= Html::a('Create MetodopagamentoController', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nomemetodopagamento',
            'descricao:ntext',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Metodopagamento $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
