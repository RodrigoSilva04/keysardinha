<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//regista o css chekout.css
$this->registerCssFile('@web/css/checkout.css');
//regista o js checkout.js
$this->registerJsFile('@web/js/checkout.js');
$this->title = 'Checkout';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$totalIva = 0;
$valorTotal = 0;
$subtotal = 0;
?>
<div class="container my-5 d-flex justify-content-center">
    <div class="window">
        <div class="order-info">
            <div class="order-info-content">
                <h2>Resumo do Pedido</h2>
                <div class="line"></div>

                <!-- Adicionar o contêiner com scroll -->
                <div class="order-table-container" style="max-height: 400px; overflow-y: auto;">
                    <?php foreach ($linhasCarrinho as $linha): ?>
                        <table class="order-table">
                            <tbody>
                            <tr>
                                <td>
                                    <?= Html::img('@web/imagensjogos/' . $linha->produto->imagem, ['alt' => 'Imagem do produto', 'class' => 'd-block ui-w-40 ui-bordered mr-4']) ?>
                                </td>
                                <td>
                                    <br> <span class="thin"><?= htmlspecialchars($linha->produto->nome) ?></span>
                                    <br> <?= htmlspecialchars($linha->produto->descricao) ?>
                                    <br> <span class="thin small"></span>
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="quantity">Quantidade: <?= $linha->quantidade ?></div>
                                    <div class="price">€<?= number_format($linha->produto->preco, 2, ',', '.') ?></div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="line"></div>
                        <?php
                        // Calcular o subtotal do produto
                        $subtotalProduto = $linha->quantidade * $linha->produto->preco;
                        // Obter a taxa de IVA
                        $taxaIva = $linha->produto->iva->taxa;
                        // Calcular o IVA
                        $ivaProduto = $subtotalProduto * ($taxaIva / 100);
                        // Acumular o IVA
                        $totalIva += $ivaProduto;
                        $subtotal += $subtotalProduto;
                        ?>
                    <?php endforeach; ?>
                </div>
                <!-- Fim do contêiner com scroll -->

                <?php
                $valorcupao = $carrinho->cupao->valor;
                $valorTotal = $subtotal - $valorcupao;
                ?>

                <div class="total">
                    <span style="float:left;">
                        <div class="thin dense">Desconto Cupao</div>
                        <div class="thin dense">IVA</div>
                        TOTAL C/IVA
                    </span>
                    <span style="float:right; text-align:right;">
                        <div class="thin dense"><?= $valorcupao ?>€</div>
                        <div class="thin dense"><?= number_format($totalIva, 2, ',', '.') ?>€</div>
                        <?= number_format($valorTotal, 2, ',', '.') ?>€
                    </span>
                </div>
            </div>
        </div>

        <!-- Informação do cartão de crédito -->
        <div class="credit-info">
            <div class="credit-info-content">
                <table class="half-input-table">
                    <tr>
                        <td>Selecione seu cartão:</td>
                        <td>
                            <div class="dropdown" id="card-dropdown">
                                <div class="dropdown-btn" id="current-card">Visa</div>
                                <div class="dropdown-select">
                                    <ul>
                                        <li>Master Card</li>
                                        <li>American Express</li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <img src="https://dl.dropboxusercontent.com/s/ubamyu6mzov5c80/visa_logo%20%281%29.png" height="80" class="credit-card-image" id="credit-card-image">
                <label for="card-number">Número do Cartão</label>
                <input class="input-field" id="card-number">
                <label for="card-holder">Nome do Titular</label>
                <input class="input-field" id="card-holder">
                <table class="half-input-table">
                    <tr>
                        <td>
                            <label for="expires">Validade</label>
                            <input class="input-field" id="expires">
                        </td>
                        <td>
                            <label for="cvc">CVC</label>
                            <input class="input-field" id="cvc">
                        </td>
                    </tr>
                </table>
                <button class="pay-btn">Finalizar Compra</button>
            </div>
        </div>
    </div>
</div>

