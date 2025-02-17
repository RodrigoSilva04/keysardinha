<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';

// Registrar o Chart.js CDN
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js', [
    'crossorigin' => 'anonymous',
]);

// Registrar graficos.js
$this->registerJsFile('@web/js/graficos.js', [
    'depends' => [\yii\web\JqueryAsset::class],
]);

?>
<div class="site-index">

    <div class="body-content">

        <div class="container">

            <div class="row">
                <!-- Estatísticas de faturas -->
                <div class="four col-md-3">
                    <div class="counter-box colored">
                        <i class="fa fa-thumbs-o-up"></i>
                        <span class="counter"><?= $numerofaturas ?></span> <!-- Mostra o número de faturas -->
                        <p>Clientes Satisfeitos</p>
                    </div>
                </div>
                <div class="four col-md-3">
                    <div class="counter-box">
                        <i class="fa fa-group"></i>
                        <span class="counter"><?= $numeroclientes ?></span>
                        <p>Membros Registrados</p>
                    </div>
                </div>
                <div class="four col-md-3">
                    <div class="counter-box">
                        <i class="fa  fa-shopping-cart"></i>
                        <span class="counter"><?= $numeroprodutos ?></span>
                        <p>Produtos</p>
                    </div>
                </div>
                <div class="four col-md-3">
                    <div class="counter-box">
                        <i class="fa  fa-user"></i>
                        <span class="counter">1563</span>
                        <p>Arvores Resgatadas</p>
                    </div>
                </div>
            </div>
            
        </div>

    </div>

</div>
