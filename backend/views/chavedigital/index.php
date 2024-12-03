<?php

use common\models\Chavedigital;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Chavedigitals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chavedigital-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Chavedigital', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'chaveativacao',
            'estado',
            [
                'attribute' => 'produto_id',
                'value' => 'produto.nome', // Usa a relação para obter o nome do produto
                'label' => 'Produto', // Título da coluna no GridView
            ],
            'datavenda',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Chavedigital $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
