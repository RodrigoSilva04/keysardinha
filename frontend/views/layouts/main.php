<?php

/** @var \yii\web\View $this */
/** @var string $content */

use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use common\models\LinhaCarrinho;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="description" content="Loja de jogos digitais com melhores ofertas e novidades!">
    <meta property="og:title" content="<?= Html::encode($this->title) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= Yii::$app->request->absoluteUrl ?>">
    <meta property="og:image" content="<?= Yii::getAlias('@web/assetslayout/img/preview.jpg') ?>">
    <meta property="og:description" content="Loja de jogos digitais com melhores ofertas e novidades!">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/assetslayout/css/fontawesome.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/assetslayout/css/templatemo-lugx-gaming.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/assetslayout/css/owl.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/assetslayout/css/animate.css') ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <!-- CSS do Toastr -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <!-- JS do Toastr sem dependência de jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right", // Posição
            "preventDuplicates": true,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000", // 5 segundos
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    </script>


    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<?php

    $carrinhoQuantidade = 0;

    // Obter o número de itens no carrinho
    if (!Yii::$app->user->isGuest) {
        $carrinho = common\models\Carrinho::findOne(['utilizadorperfil_id' => Yii::$app->user->id]);
    if ($carrinho) {
        $carrinhoQuantidade = LinhaCarrinho::find()
            ->where(['carrinho_id' => $carrinho->id])
                ->sum('quantidade') ?? 0;
        }
    }
?>
<?php
$flashes = Yii::$app->session->getAllFlashes();
$js = '';
foreach ($flashes as $type => $message) {
    // Escapa as mensagens para evitar XSS
    $message = Html::encode($message);
    $js .= "toastr.{$type}('{$message}');";
}
if (!empty($js)) {
    $this->registerJs($js, \yii\web\View::POS_READY);
}
?>



<!-- Header -->
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- Logo -->
                    <?= Html::a(
                        Html::img('@web/logokeysardinha.webp', ['alt' => 'Logo', 'style' => 'width: 158px;']),
                        Yii::$app->homeUrl,
                        ['class' => 'logo']
                    ) ?>
                    <!-- Logo End -->

                    <!-- Menu -->
                    <ul class="nav d-flex justify-content-center align-items-center">
                        <li><?= Html::a('Home', ['/site/index'], ['class' => 'active']) ?></li>
                        <li><?= Html::a('Catálogo', ['/produto/index']) ?></li>
                        <li><?= Html::a('Favoritos', ['/favoritos/index']) ?></li>
                        <li><?= Html::a('Contact Us', ['/site/contact']) ?></li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['carrinho/index']) ?>">
                                <i class="fas fa-shopping-cart"></i>
                                <?php if ($carrinhoQuantidade > 0): ?>
                                    <span class="badge badge-pill badge-primary ">
                                <?= $carrinhoQuantidade > 9 ? '9+' : $carrinhoQuantidade ?>
                            </span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <?php if (Yii::$app->user->isGuest): ?>
                            <li><?= Html::a('<i class="fas fa-sign-in-alt"></i> Sign In', ['/site/signup']) ?></li>
                        <?php else: ?>
                            <li><?= Html::a('Meu Perfil', ['/perfil/index']) ?></li>
                            <li><?= Html::a('<i class="fas fa-sign-out-alt"></i> Logout (' . Yii::$app->user->identity->username . ')', ['/site/logout'], ['data-method' => 'post']) ?></li>
                        <?php endif; ?>

                    </ul>
                    <a class="menu-trigger" aria-label="Open menu">
                        <span>Menu</span>
                    </a>
                    <!-- Menu End -->
                </nav>
            </div>
        </div>
    </div>
</header>
<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3><?= $this->title
                    ?></h3>
                <span class="breadcrumbe"><a href="<?= Url::to('site/index')?>">Home</a> > <?= $this->title
                ?></span>
            </div>
        </div>
    </div>
</div>
<main role="main" class="section trending">
    <div class="container-fluid">
        <?= $content ?>
    </div>
</main>

<footer class="footer-area bg-dark text-light py-3">
    <div class="container">
        <div class="row">
            <div class="col text-start">
                &copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?>
            </div>
            <div class="col text-end">
                Powered by <?= Html::a('Yii Framework', 'https://www.yiiframework.com/', ['target' => '_blank']) ?>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
