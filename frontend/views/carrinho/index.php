<?php

use common\models\Carrinho;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->registerCssFile('@web/css/carrinho.css');
$this->title = 'Carrinhos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrinho-index">

    <!-- Carrinho free template -->
    <div class="container px-3 my-5 clearfix">
        <!-- Shopping cart table -->
        <div class="card">
            <div class="card-header">
                <h2>As tuas compras</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered m-0">
                        <thead>
                        <tr>
                            <!-- Set columns width -->
                            <th class="text-center py-3 px-4" style="min-width: 400px;">Nome do produto &amp; Detalhes</th>
                            <th class="text-right py-3 px-4" style="width: 100px;">Preço</th>
                            <th class="text-center py-3 px-4" style="width: 120px;">Quantidade</th>
                            <th class="text-right py-3 px-4" style="width: 100px;">Subtotal</th>
                            <th class="text-center align-middle py-3 px-0" style="width: 40px;"><a href="#" class="shop-tooltip float-none text-light" title="" data-original-title="Clear cart"><i class="ino ion-md-trash"></i></a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $total = 0; ?>
                        <?php foreach ($linhasCarrinho as $linha): ?>
                            <?php $subtotal = $linha->produto->preco * $linha->quantidade; ?>
                            <tr>
                                <td class="p-4">
                                    <div class="media align-items-center">
                                        <?= Html::img('@web/imagensjogos/' . $linha->produto->imagem, ['alt' => 'Imagem do produto', 'class' => 'd-block ui-w-40 ui-bordered mr-4']) ?>
                                        <div class="media-body">
                                            <a href="#" class="d-block text-dark"><?= $linha->produto->nome ?></a>
                                            <small>
                                                <span class="text-muted">Categoria:</span> <?= $linha->produto->categoria->nome ?> &nbsp;
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-right font-weight-semibold align-middle p-4">€<?= number_format($linha->produto->preco, 2) ?></td>
                                <td class="align-middle p-4">
                                    <input type="text" class="form-control text-center" value="<?= $linha->quantidade ?>" readonly>
                                </td>
                                <td class="text-right font-weight-semibold align-middle p-4">€<?= number_format($linha->produto->preco * $linha->quantidade, 2) ?></td>
                                <td class="text-center align-middle px-0">
                                    <a href="<?= \yii\helpers\Url::to(['carrinho/remover-carrinho', 'idProduto' => $linha->produto_id]) ?>"
                                       class="shop-tooltip close float-none text-danger"
                                       title="Remove"
                                       data-original-title="Remove">X</a>
                                </td>
                            </tr>
                            <?php $total += $subtotal; ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- / Shopping cart table -->
                <!-- Aplicar desconto, se houver -->
                <?php
                $desconto = $carrinho->cupao_id != null ? $carrinho->cupao->valor : 0;

                $totalComDesconto = $total - $desconto;
                if ($totalComDesconto < 0) {
                    $totalComDesconto = 0;
                }
                ?>

                <div class="d-flex flex-wrap justify-content-between align-items-center pb-4">
                    <div class="mt-4">
                        <form action="<?= \yii\helpers\Url::to(['carrinho/verificar-cupao']) ?>" method="post">
                            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()); ?>

                            <!-- Campo de texto para o código do cupão -->
                            <div class="form-group">
                                <label for="codigo">Código do Cupão</label>
                                <input type="text" id="codigo" name="codigo" class="form-control" placeholder="Digite o código do cupão">
                            </div>
                            <!-- Botão de envio -->
                            <button type="submit" class="btn btn-outline-primary">Aplicar Cupão</button>

                        </form>
                    </div>
                    <div class="d-flex">
                        <div class="text-right mt-4" style="margin-right: 100px;">
                            <label class="text-muted font-weight-normal m-0">Desconto</label>
                            <div class="text-large"><strong><?= $desconto?>€</strong></div>
                        </div>
                        <div class="text-right mt-4">
                            <label class="text-muted font-weight-normal m-0">Preço Total</label>
                            <div class="text-large"><strong><?= $totalComDesconto ?>€</strong></div>
                        </div>
                    </div>
                </div>


                <div class="float-right">
                    <button type="button" class="btn btn-lg btn-default md-btn-flat mt-2 mr-3">Voltar a comprar</button>
                    <a href="<?= \yii\helpers\Url::to(['carrinho/checkout']) ?>" class="btn btn-lg btn-primary mt-2">Checkout</a>
                </div>

            </div>
        </div>
    </div>


</div>
