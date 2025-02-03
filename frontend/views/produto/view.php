<?php

use common\models\Comentario;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */



$this->title = $produto->nome;
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

//register js comentario.js
$this->registerJsFile('@web/js/comentario.js');
//register css comentario.css
$this->registerCssFile('@web/css/comentarios.css');
?>
<div class="single-product section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="left-image">
                    <?= Html::img('@web/imagensjogos/' . $produto->imagem, ['alt' => 'Imagem do produto']) ?>
                </div>
            </div>
            <div class="col-lg-6 align-self-center">
                <h4><?= $produto->nome ?></h4>
                <span class="price">
    <?php if ($produto->desconto && $produto->desconto->percentagem > 0): ?>
        <span class="original-price" style="text-decoration: line-through;"><?= $produto->preco ?>€</span>
        <span class="discounted-price">
            <?= $produto->preco - ($produto->preco * $produto->desconto->percentagem / 100) ?>€
        </span>
    <?php else: ?>
        <?= $produto->preco ?>€
    <?php endif; ?>
</span>

                <ul>
                    <li><span>Data de Lançamento:</span><?= $produto->datalancamento?></li>
                </ul>
                <form id="qty" action="<?= \yii\helpers\Url::to(['carrinho/add-to-cart', 'IdProduto' => $produto->id]) ?>" method="get">
                    <input type="number" class="form-control" name="qty" id="qty" placeholder="1" min="1">
                    <a id="botton-addtocart" href="<?= \yii\helpers\Url::to(['carrinho/add-to-cart', 'IdProduto' => $produto->id]) ?>" type="submit" class="btn btn-primary botton-view"><i class="fa fa-shopping-bag"></i> Adicionar ao Carrinho</a>
                </form>
                <ul>
                    <li>
                        <span>Stock:</span>
                        <?php
                        if($produto->stockdisponivel > 0){
                            echo '<span style="color: green;">Disponível</span>';
                        } else {
                            echo '<span style="color: red;">Indisponível</span>';
                        }
                        ?>
                    </li>
                </ul>

                <ul>
                    <li><span>Categoria:</span><?=$produto->categoria->nome?></li>
                </ul>
            </div>
            <div class="col-lg-12">
                <div class="sep"></div>
            </div>
        </div>
    </div>
</div>

<div class="more-info">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-content">
                    <div class="row">
                        <div class="nav-wrapper">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Descrição</button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                <p><?=$produto->descricao?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-5 col-md-6 col-12 pb-4">
            <h1>Comments</h1>

            <?php if (empty($comentarios)): ?>
                <p>Ainda não há comentários para este produto.</p>
            <?php else: ?>
                <?php foreach ($comentarios as $comentario): ?>
                    <div class="comment mt-4 text-justify <?= $comentario->avaliacao > 3 ? 'float-left' : 'float-right' ?>">
                        <!-- Exibe a imagem do usuário -->
                        <?= Html::img('@web/logokeysardinha.webp', ['alt' => 'icon', 'Class' => 'rounded-circle' ,'style' => 'width: 60px; height: 60px;'])
                         ?>
                        <!-- Exibe o nome do usuário -->
                        <h4><?= User::findOne($comentario->utilizadorperfil_id)->username ?></h4>
                        <!-- Exibe a data do comentário -->
                        <span>- <?= $comentario->datacriacao?></span>
                        <br>
                        <!-- Exibe a descrição do comentário -->
                        <p><?= nl2br($comentario->descricao) ?></p>
                        <!-- Exibe a avaliação -->
                        <p>Rating: <?= $comentario->avaliacao ?>/5</p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-4">
            <?php
            $comentario = new Comentario();
            $form = ActiveForm::begin([
                'id' => 'form-comment',
                'method' => 'post',
                'action' => ['comentario/create'], // Defina a URL correta de envio
                'options' => ['class' => 'form'],
            ]); ?>

            <div class="form-group">
                <h4>Leave a comment</h4>
                <?= $form->field($comentario, 'descricao')->textarea([
                    'rows' => 5,
                    'style' => 'background-color: white;'
                ])->label(false) ?>
            </div>

            <div class="form-group">
                <label for="rating">Rating</label><br>
                <?= $form->field($comentario, 'avaliacao')->radioList([1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'], ['class' => 'rating'])->label(false) ?>
            </div>

            <!-- Campo oculto para o produto_id -->
            <?= Html::hiddenInput('produto_id', $produto->id); ?>

            <div class="form-group">
                <?= Html::submitButton('Post Comment', ['class' => 'btn', 'id' => 'post']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>



    </div>
</div>






<div class="section categories related-games">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-heading">
                    <h6>Action</h6>
                    <h2>Related Games</h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="main-button">
                    <a href="shop.html">View All</a>
                </div>
            </div>
            <?php foreach ($produtosrelacionados as $produto): ?>
                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <div class="thumb">
                            <a href="<?= \yii\helpers\Url::to(['produto/view', 'id' => $produto->id]) ?>">
                                <?= // Se a imagem estiver null, mostra uma imagem padrão
                                $produto->imagem == null ? Html::img('@web/imagensjogos/imagemdefault.jpg', ['alt' => 'Imagem do produto']) :
                                    Html::img('@web/imagensjogos/' . $produto->imagem, ['alt' => 'Imagem do produto']) ?>
                            </a>
                            <span class="price"><?= $produto->preco ?>€</span>
                        </div>
                        <div class="down-content">
                            <span class="category"><?= $produto->categoria->nome ?></span> <!-- A categoria pode ser um campo do modelo -->
                            <h4><?= $produto->nome ?></h4>
                            <a href="<?= \yii\helpers\Url::to(['carrinho/add-to-cart', 'IdProduto' => $produto->id]) ?>">
                                <i class="fa fa-shopping-bag"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
