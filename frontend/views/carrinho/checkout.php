<?php
use yii\helpers\Html;
use yii\helpers\Url;
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
// Acumular o total de descontos
$totalDescontos = 0;
?>
<div class="container my-5 d-flex justify-content-center">
    <div class="window">
        <div class="order-info">
            <div class="order-info-content">
                <h2>Resumo do Pedido</h2>
                <div class="line"></div>

                <!-- Adicionar o contêiner com scroll -->
                <div class="order-table-container" style="max-height: 400px; overflow-y: auto;">
                    <?php
                    foreach ($linhasCarrinho as $linha): ?>
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
                                    <div class="price">€<?= number_format($linha->preco_unitario, 2, ',', '.') ?></div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="line"></div>

                        <?php
                        // Calcular o subtotal do produto (sem precisar de recalcular o desconto)
                        $subtotalProduto = $linha->quantidade * $linha->preco_unitario;

                        // Inicializar variáveis de desconto
                        $valorDescontoProduto = 0;

                        // Verificar se o produto tem desconto
                        if ($linha->produto->desconto != null) {
                            // O desconto já está aplicado no preco_unitario, então apenas calcule o valor do desconto
                            $percentagemDesconto = $linha->produto->desconto->percentagem;
                            // Calcular o valor do desconto em dinheiro para esse produto (preço original - preço com desconto)
                            $valorDescontoProduto = ($linha->produto->preco - $linha->preco_unitario) * $linha->quantidade;
                            // Acumular o total de descontos
                            $totalDescontos += $valorDescontoProduto;
                        }

                        // Obter a taxa de IVA
                        $taxaIva = $linha->produto->iva->taxa;
                        // Calcular o IVA sobre o subtotal (já com o desconto aplicado)
                        $ivaProduto = $subtotalProduto * ($taxaIva / 100);
                        // Acumular o total de IVA
                        $totalIva += $ivaProduto;

                        // Acumular o subtotal (já com o desconto aplicado)
                        $subtotal += $subtotalProduto;
                        ?>

                    <?php endforeach; ?>

                </div>
                <!-- Fim do contêiner com scroll -->

                <?php


                if ($carrinho->cupao != null) {
                    $valorcupao = $carrinho->cupao->valor;
                    $valorTotal = $subtotal - $valorcupao;
                } else {
                    $valorcupao = 0;
                    $valorTotal = $subtotal;
                }
                ?>

                <div class="total">
                    <span style="float:left;">
                        <div class="thin dense">Descontos Jogos</div>
                        <div class="thin dense">Desconto Cupao</div>
                        <div class="thin dense">IVA</div>
                        TOTAL C/IVA
                    </span>
                    <span style="float:right; text-align:right;">
                        <div class="thin dense"><?= $totalDescontos ?>€</div>
                        <div class="thin dense"><?= $valorcupao ?>€</div>
                        <div class="thin dense"><?= number_format($totalIva, 2, ',', '.') ?>€</div>
                        <?= number_format($valorTotal, 2, ',', '.') ?>€
                    </span>
                </div>
            </div>
        </div>


        <!-- Informação do pagamento -->
        <div class="payment-info">
            <div class="payment-info-content">
                <table class="half-input-table">
                    <tr>
                        <td>Método de Pagamento:</td>
                        <td>
                            <div class="dropdown" id="payment-dropdown">
                                <div id="current-payment" class="dropdown-btn">Selecione um Método</div>
                                <div class="dropdown-select">
                                    <ul>
                                        <?php foreach ($metodospagamento as $metodo): ?>
                                            <li data-method="<?= $metodo->id ?>" onclick="selectPaymentMethod(<?= $metodo->id ?>, '<?= htmlspecialchars($metodo->nomemetodopagamento) ?>')">
                                                <?= htmlspecialchars($metodo->nomemetodopagamento) ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>

                                </div>

                            </div>
                        </td>
                    </tr>
                </table>

                <!-- Formulários de Pagamento -->
                <?php foreach ($metodospagamento as $metodo): ?>
                    <div id="payment-form-<?= $metodo->id ?>" class="payment-form" style="display: none;">
                        <img src="<?=
                        ($metodo->id == 1) ? '../paypal.png' :
                            (($metodo->id == 2) ? '../MBway.png' : '../visa.png')
                        ?>" height="100" class="payment-card-image">

                        <?php if ($metodo->id == 1): ?> <!-- Exemplo: PayPal -->
                            <label for="paypal-email">Email do PayPal</label>
                            <input class="input-field" id="paypal-email" name="paypal_email">
                        <?php elseif ($metodo->id == 2): ?> <!-- Exemplo: MBWay -->
                            <label for="mbway-number">Número de Telefone</label>
                            <input class="input-field" id="mbway-number" name="mbway_number" maxlength="9">
                        <?php elseif ($metodo->id == 3): ?> <!-- Exemplo: Cartão de Crédito -->
                            <label for="card-number">Número do Cartão</label>
                            <input class="input-field" id="card-number" name="card_number" maxlength="16">
                            <label for="card-holder">Nome do Titular</label>
                            <input class="input-field" id="card-holder" name="card_holder">
                            <table class="half-input-table">
                                <tr>
                                    <td>
                                        <label for="expires">Validade</label>
                                        <input class="input-field" id="expires" name="expires" placeholder="MM/AA" maxlength="5">
                                    </td>
                                    <td>
                                        <label for="cvc">CVC</label>
                                        <input class="input-field" id="cvc" name="cvc" maxlength="3">
                                    </td>
                                </tr>
                            </table>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>



                <!-- Botão de Finalizar Compra -->
                <a href="#" id="finalize-purchase-btn" class="pay-btn">Finalizar Compra</a>
            </div>
        </div>


    </div>

</div>

