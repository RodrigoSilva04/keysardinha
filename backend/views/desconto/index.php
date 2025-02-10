<?php

use common\models\Desconto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Descontos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="desconto-index">

    <p>
        <?= Html::a('Create Desconto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'percentagem',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Desconto $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
