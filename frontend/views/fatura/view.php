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

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card">
        <div class="row">
            <div class="col-md-8 cart">
                <div class="title">
                    <div class="row">
                        <div class="col"><h4><b>Fatura</b></h4></div>
                        <div class="col align-self-center text-right text-muted"></div>
                        foi encontrado este numeros de linhas <?= count($linhasFatura) ?>
                    </div>
                </div>

                <?php foreach ($linhasFatura as $linha): ?>
                    <div class="row border-top border-bottom">
                        <div class="row main align-items-center" id="row-produto-comprado">
                            <div class="col-2">
                                <?= Html::img('@web/imagensjogos/' . $linha->produto->imagem, ['alt' => 'Imagem do produto']) ?>

                            </div>
                            <div class="col">
                                <div class="row"><?= $linha->produto->nome ?></div>
                            </div>
                            <div class="col">
                                <div class="row"><?= $linha->subtotal ?></div>
                            </div>
                            <div class="col">
                                <span class="quantity"><?= $linha->quantidade ?></span>
                            </div>
                            <div class="col">
                                <span class="price">&euro; <?= number_format($linha->subtotal, 2) ?></span>
                            </div>
                            <div class="col">
                                <span id="chavedigital" class="quantity"><?= $linha->chavedigital->chaveativacao ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- Voltar para a loja -->
                <div class="back-to-shop">
                    <a href="#">&leftarrow;</a><span class="text-muted">Back to shop</span>
                </div>
            </div>
        </div>
    </div>


</div>
