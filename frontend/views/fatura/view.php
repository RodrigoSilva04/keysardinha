<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Fatura $fatura */

$this->title = $fatura->id;
$this->params['breadcrumbs'][] = ['label' => 'Faturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
//Registar css
$this->registerCssFile('@web/css/fatura-index.css');
?>

<div class="fatura-view">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="card">
        <div class="row justify-content-center">
            <div class="col-md-10 cart">
                <div class="title text-center">
                    <div class="row">
                        <div class="col">
                            <h4><b>Fatura</b></h4>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <ul class="responsive-table">
                        <li class="table-header">
                            <div class="col col-1">Imagem</div>
                            <div class="col col-2">Nome Produto</div>
                            <div class="col col-3">Subtotal</div>
                            <div class="col col-4">Quantidade</div>
                            <div class="col col-5">Chave Digital</div>
                        </li>
                        <div class="order-table-container" style="max-height: 400px; overflow-y: auto;">
                            <div class="tab-pane fade show active" id="invoices" role="tabpanel" aria-labelledby="invoices-tab">
                                <?php if (!empty($linhasFatura)): ?>
                                    <?php foreach ($linhasFatura as $linha): ?>
                                        <li class="table-row text-center">
                                            <div class="col col-1" data-label="Imagem">
                                                <?= Html::img('@web/imagensjogos/' . $linha->produto->imagem, ['alt' => 'Imagem do produto', 'style' => 'width: 50px; height: auto;']) ?>
                                            </div>
                                            <div class="col col-2" data-label="Nome Produto">
                                                <?= Html::encode($linha->produto->nome) ?>
                                            </div>
                                            <div class="col col-3" data-label="Subtotal">
                                                <?= number_format($linha->subtotal, 2, ',', '.') ?>&euro;
                                            </div>
                                            <div class="col col-4" data-label="Quantidade">
                                                <?= Html::encode($linha->quantidade) ?>
                                            </div>
                                            <div class="col col-5" data-label="Chave Digital">
                                                <?= Html::encode($linha->chavedigital->chaveativacao) ?>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="table-row">
                                        <div class="col" style="text-align: center;" colspan="6">
                                            Nenhuma fatura encontrada.
                                        </div>
                                    </li>
                                <?php endif; ?>
                            </div>
                        </div>
                    </ul>
                </div>
                <!-- Voltar para a loja -->
                <div class="back-to-shop">
                    <a href="<?= Yii::$app->urlManager->createUrl(['produto/index']) ?>">&leftarrow;</a>
                    <span class="text-muted">Back to shop</span>
                </div>
            </div>
        </div>
    </div>
</div>