<?php

use common\models\Produto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Produtos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-index">

    <p>
        <?= Html::a('Create Produto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nome',
            'descricao:ntext',
            'preco',
            'imagem',
            'datalancamento',
            'stockdisponivel',
            [
                'attribute' => 'categoria_id',
                'value' => 'categoria.nome', // Usa a relação para obter o nome da categoria
                'label' => 'Categoria', // Título da coluna no GridView

            ],
            [
                'attribute' => 'desconto_id',
                'value' => 'desconto.percentagem', // Usa a relação para obter o nome da categoria
                'label' => 'Desconto', // Título da coluna no GridView

            ],
            [
                'attribute' => 'iva_id',
                'value' => 'iva.taxa', // Usa a relação para obter o nome da categoria
                'label' => 'Iva', // Título da coluna no GridView

            ],

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Produto $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
