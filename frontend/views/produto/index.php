<?php
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

use yii\helpers\Html;

$this->title = 'Lista de Produtos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="trending-filter">

        <li>
            <a class="is_active" href="#!" data-filter="*">Show All</a>
        </li>
        <li>
            <a href="#!" data-filter=".adv">Adventure</a>
        </li>
        <li>
            <a href="#!" data-filter=".str">Strategy</a>
        </li>
        <li>
        <a href="#!" data-filter=".rac">Racing</a>
        </li>
    </ul>
    <div class="row trending-box">
        <?php foreach ($produtos as $produto): ?>
            <div class="col-lg-3 col-md-6 align-self-center mb-30 trending-items col-md-6 adv">
                <div class="item">
                <div class="thumb">
                    <a href="produto/detalhes">
                        <?= Html::img('@web/imagensjogos/' . $produto->imagem, ['alt' => 'Imagem do produto']) ?>
                        <span class="price"><?= $produto->preco ?>€</span>
                    </div>
                    <div class="conteudo-baixo">
                        <span class="category"><?= $produto->categoria->nome ? $produto->categoria->nome : 'Sem categoria' ?></span>
                        <h4><?= $produto->nome?></h4>
                        <a href=""><i class="fa fa-shopping-bag"></i></a>
                    </div>
                </div>
                </div>
        <?php endforeach; ?>
    </div>

</div>
