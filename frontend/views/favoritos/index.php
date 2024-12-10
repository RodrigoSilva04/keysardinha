<?php

use common\models\Favoritos;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Favoritos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="favoritos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row trending-box">
        <?php foreach ($dataProvider->models as $favorito): ?>
            <?php $produto = $favorito->produto; ?>
            <?php if ($produto): // Verificar se o produto existe ?>
                <div class="col-lg-3 col-md-6 mb-30 trending-items adv" data-category="<?= $produto->categoria_id; ?>">
                    <div class="item">
                        <div class="thumb">
                            <a href="<?= \yii\helpers\Url::to(['produto/view', 'id' => $produto->id]) ?>">
                                <?= $produto->imagem == null
                                    ? Html::img('@web/imagensjogos/imagemdefault.png', ['alt' => 'Imagem do produto', 'class' => 'img-fluid'])
                                    : Html::img('@web/imagensjogos/' . $produto->imagem, ['alt' => 'Imagem do produto', 'class' => 'img-fluid'])
                                ?>
                            </a>
                            <span class="price"><?= Yii::$app->formatter->asCurrency($produto->preco, 'EUR') ?></span>
                        </div>
                        <div class="conteudo-baixo text-center">
                            <span class="category"><?= $produto->categoria !== null ? Html::encode($produto->categoria->nome) : 'Sem categoria' ?></span>
                            <h4><?= Html::encode($produto->nome) ?></h4>
                            <a href="#" class="btn btn-primary mt-2">Adicionar ao carrinho</a>
                            <?= Html::a(
                                'Remover dos Favoritos',
                                ['favoritos/delete', 'produto_id' => $produto->id],
                                [
                                    'class' => 'btn btn-danger mt-2',
                                    'data' => [
                                        'confirm' => 'Tem certeza de que deseja remover este produto dos favoritos?',
                                        'method' => 'post', // Garante que a requisição será segura
                                    ],
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>




</div>
