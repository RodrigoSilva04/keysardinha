<?php
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

use common\models\Favoritos;
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
                            <?= // Se a imagem estiver null, mostra uma imagem padrão
                            $produto->imagem == null ? Html::img('@web/imagensjogos/imagemdefault.jpg', ['alt' => 'Imagem do produto']) :
                                Html::img('@web/imagensjogos/' . $produto->imagem, ['alt' => 'Imagem do produto']) ?>
                            <span class="price"><?= $produto->preco ?>€</span>
                        </a>
                    </div> <!-- Fim de .thumb -->

                    <div class="conteudo-baixo">
                        <span class="category"><?= $produto->categoria != null ? $produto->categoria->nome : 'Sem categoria' ?></span>
                        <h4><?= $produto->nome ?></h4>
                        <a href="<?= \yii\helpers\Url::to(['carrinho/add-to-cart', 'IdProduto' => $produto->id]) ?>"
                           class="button-addtocart padding-1rem mb-3"
                           id="add-to-cart-Produto-<?= $produto->id ?>">Adicionar ao carrinho</a>

                        <!-- Verifica se o produto já está nos favoritos -->
                        <?php if (Favoritos::isFavorito($produto->id)): ?>
                            <!-- Produto está nos favoritos, mostrar opção para remover -->
                            <?= Html::a(
                                'Remover dos Favoritos',
                                ['favoritos/delete', 'produto_id' => $produto->id],
                                [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'Tem certeza de que deseja remover este produto dos favoritos?',
                                        'method' => 'post', // Garante que a requisição será segura
                                    ],
                                ]
                            ) ?>
                        <?php else: ?>
                            <!-- Produto não está nos favoritos, mostrar opção para adicionar -->
                            <a href="<?= \yii\helpers\Url::to(['favoritos/create', 'idProduto' => $produto->id]) ?>" class=button-addtofavorite mb-3">
                                Adicionar aos Favoritos
                            </a>
                        <?php endif; ?>
                    </div> <!-- Fim de .conteudo-baixo -->
                </div> <!-- Fim de .item -->
            </div> <!-- Fim de .col-lg-3 -->
        <?php endforeach; ?>
    </div> <!-- Fim de .row -->
</div>
