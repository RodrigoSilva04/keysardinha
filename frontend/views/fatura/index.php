<?php

use common\models\Fatura;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Faturas';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/fatura.css');
?>
<div class="fatura-index">

    <div class="container">
        <h2>O teu Histórico de Compras</h2>
        <ul class="responsive-table">
            <li class="table-header">
                <div class="col col-1">Data da Compra</div>
                <div class="col col-3">Total</div>
                <div class="col col-4">Estado</div>
                <div class="col col-5">Detalhes</div>
            </li>

            <?php if (!empty($faturas)): ?>
                <?php foreach ($faturas as $fatura): ?>
                    <li class="table-row">
                        <div class="col col-1" data-label="Data da Compra"><?= date('d/m/Y', strtotime($fatura->datafatura)) ?></div>
                        <div class="col col-3" data-label="Total">€<?= number_format($fatura->valor_total, 2) ?></div>
                        <div class="col col-4" data-label="Estado"><?= $fatura->estado ?></div>
                        <div class="col col-5" data-label="Detalhes">
                            <?= Html::a('Detalhes', ['view', 'id' => $fatura->id], ['class' => 'btn btn-primary']) ?>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="table-row">
                    <div class="col col-1" colspan="4">Nenhuma fatura encontrada.</div>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
