<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */



$this->title = $produto->nome;
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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
                <h4><?= $produto->nome?></h4>
                <span class="price"><?=$produto->preco?>€</span>
                <p><?= $produto->descricao?></p>
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
                        <div class="nav-wrapper ">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews (3)</button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                <p>
                                    <?=$produto->descricao?>
                                </p>
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <p>Coloring book air plant shabby chic, crucifix normcore raclette cred swag artisan activated charcoal. PBR&B fanny pack pok pok gentrify truffaut kitsch helvetica jean shorts edison bulb poutine next level humblebrag la croix adaptogen. <br><br>Hashtag poke literally locavore, beard marfa kogi bruh artisan succulents seitan tonx waistcoat chambray taxidermy. Same cred meggings 3 wolf moon lomo irony cray hell of bitters asymmetrical gluten-free art party raw denim chillwave tousled try-hard succulents street art.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
            <div class="col-lg col-sm-6 col-xs-12">
                <div class="item">
                    <h4>Action</h4>
                    <div class="thumb">
                        <a href="product-details.html"><img src="assets/images/categories-01.jpg" alt=""></a>
                    </div>
                </div>
            </div>
            <div class="col-lg col-sm-6 col-xs-12">
                <div class="item">
                    <h4>Action</h4>
                    <div class="thumb">
                        <a href="product-details.html"><img src="assets/images/categories-05.jpg" alt=""></a>
                    </div>
                </div>
            </div>
            <div class="col-lg col-sm-6 col-xs-12">
                <div class="item">
                    <h4>Action</h4>
                    <div class="thumb">
                        <a href="product-details.html"><img src="assets/images/categories-03.jpg" alt=""></a>
                    </div>
                </div>
            </div>
            <div class="col-lg col-sm-6 col-xs-12">
                <div class="item">
                    <h4>Action</h4>
                    <div class="thumb">
                        <a href="product-details.html"><img src="assets/images/categories-04.jpg" alt=""></a>
                    </div>
                </div>
            </div>
            <div class="col-lg col-sm-6 col-xs-12">
                <div class="item">
                    <h4>Action</h4>
                    <div class="thumb">
                        <a href="product-details.html"><img src="assets/images/categories-05.jpg" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
