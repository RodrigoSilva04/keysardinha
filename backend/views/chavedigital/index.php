<?php

use common\models\Chavedigital;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Gerir Chaves de jogos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chavedigital-index">

    <div>
    <p>
        <?= Html::a('Create Chavedigital', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::beginForm(['chavedigital/limpar-chaves-usadas'], 'post') ?>
        <?= Html::submitButton('Limpar Chaves Usadas', [
            'class' => 'btn btn-danger', // Classe de estilo para o botão (pode ser 'btn-warning', 'btn-danger', etc.)
            'data' => [
                'confirm' => 'Tem certeza de que deseja eliminar todas as chaves digitais usadas?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::endForm() ?>
    </p>
    </div>
    <div class="sincronizar-stocks">
        <?= Html::a('Sincronizar Stocks', ['sincronizar-stocks'], [
            'class' => 'btn btn-primary', // Estilo do botão
            'data' => [
                'confirm' => 'Tem certeza que deseja sincronizar os stocks?', // Confirmação antes de executar
                'method' => 'post', // Tipo de requisição será POST
            ],
        ]) ?>
    </div>



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
