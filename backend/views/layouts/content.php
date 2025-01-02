<?php
/* @var $content string */

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->registerCssFile('@web/css/site.css', [
    'depends' => [\yii\bootstrap4\BootstrapAsset::class],
]);

// Registrando o Font Awesome (CDN)
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css', [
    'integrity' => 'sha384-...', // Se necessário, adicione o atributo de integridade
    'crossorigin' => 'anonymous',
]);

// Registrando o jQuery (CDN)
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js', [
    'integrity' => 'sha384-...', // Se necessário, adicione o atributo de integridade
    'crossorigin' => 'anonymous',
    'position' => View::POS_HEAD, // Define o posicionamento do script
]);
//Registe js site.js
$this->registerJsFile('@web/js/site.js', [
    'depends' => [\yii\web\JqueryAsset::class],
]);
?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= Html::encode($this->title ?? $this->context->id) ?></h1>
                </div>
                <div class="col-sm-6">
                    <?= Breadcrumbs::widget([
                        'links' => $this->params['breadcrumbs'] ?? [],
                        'options' => ['class' => 'breadcrumb float-sm-right']
                    ]); ?>
                </div>
            </div>
        </div>
    </div>


    <div class="container">

        <div class="row">

            <div class="four col-md-3">
                <div class="counter-box colored">
                    <i class="fa fa-thumbs-o-up"></i>
                    <span class="counter">2147</span>
                    <p>Happy Customers</p>
                </div>
            </div>
            <div class="four col-md-3">
                <div class="counter-box">
                    <i class="fa fa-group"></i>
                    <span class="counter">3275</span>
                    <p>Registered Members</p>
                </div>
            </div>
            <div class="four col-md-3">
                <div class="counter-box">
                    <i class="fa  fa-shopping-cart"></i>
                    <span class="counter">289</span>
                    <p>Available Products</p>
                </div>
            </div>
            <div class="four col-md-3">
                <div class="counter-box">
                    <i class="fa  fa-user"></i>
                    <span class="counter">1563</span>
                    <p>Saved Trees</p>
                </div>
            </div>
        </div>
    </div>

</div>
