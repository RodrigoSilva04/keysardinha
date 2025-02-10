<?php

use common\models\Cupao;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Cupaos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cupao-index">

    <p>
        <?= Html::a('Create Cupao', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'datavalidade',
            'valor',
            'ativo',
            'codigo',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Cupao $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>