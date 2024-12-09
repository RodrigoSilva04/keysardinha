<?php
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

use yii\helpers\Html;

$this->title = 'Lista de Produtos';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/produtos.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="produto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="trending-filter">
        <li>
            <a class="is_active" href="#" data-filter="*">Show All</a>
        </li>
        <?php foreach ($categorias as $categoria): ?>
        <li>
            <a href="#" class="category-filter" data-filter="<?= $categoria->id ?>"><?=$categoria->nome?></a>
        </li>
        <?php endforeach; ?>

    </ul>
    <div class="row trending-box">
        <?php foreach ($produtos as $produto): ?>
            <div class="col-lg-3 col-md-6 align-self-center mb-30 trending-items col-md-6 adv" data-category="<?= $produto->categoria_id; ?>">
                <div class="item">
                <div class="thumb">
                    <a href="<?= \yii\helpers\Url::to(['produto/view', 'id' => $produto->id]) ?>">
                        <?= //Se a imagem estiver null, mostra uma imagem padrão
                        $produto->imagem == null ? Html::img('@web/imagensjogos/imagemdefault.jpg', ['alt' => 'Imagem do produto']) :

                        Html::img('@web/imagensjogos/' . $produto->imagem, ['alt' => 'Imagem do produto']) ?>
                        <span class="price"><?= $produto->preco ?>€</span>
                    </div>
                    <div class="conteudo-baixo">
                        <span class="category"><?= $produto->categoria!= null ? $produto->categoria->nome : 'Sem categoria' ?></span>
                        <h4><?= $produto->nome?></h4>
                        <a href=""><i class="btn btn-primary padding-1rem">Adicionar ao carrinho</i></a>
                        <a href="<?= \yii\helpers\Url::to(['produto/addFavoritos', 'id' => $produto->id]) ?>"><i class="btn btn-danger padding-1rem">Adicionar aos Favoritos</i></a>
                    </div>
                </div>
                </div>
        <?php endforeach; ?>
    </div>

</div>
