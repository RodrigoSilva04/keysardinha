<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

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
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/assetslayout/css/fontawesome.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/assetslayout/css/templatemo-lugx-gaming.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/assetslayout/css/owl.css') ?>">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/assetslayout/css/animate.css') ?>">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

    <?php $this->head() ?>
    <style>

    </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <?= Html::a(
                        Html::img('@web/logokeysardinha.webp', ['alt' => 'Logo', 'style' => 'width: 158px;']),
                        Yii::$app->homeUrl,
                        ['class' => 'logo']
                    ) ?>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li><?= Html::a('Home', ['/produto/index'], ['class' => 'active']) ?></li>
                        <li><?= Html::a('Catálogo', ['/produto/index']) ?></li>
                        <li><?= Html::a('Favoritos', ['/favoritos/index']) ?></li>
                        <li><?= Html::a('Contacto', ['/site/contact']) ?></li>
                        <?php if (Yii::$app->user->isGuest): ?>
                            <li><?= Html::a('Sign In', ['/site/signup']) ?></li>
                        <?php else: ?>
                            <li><?= Html::a('Logout (' . Yii::$app->user->identity->username . ')', ['/site/logout'], ['data-method' => 'post']) ?></li>
                        <?php endif; ?>
                    </ul>
                    <a class="menu-trigger">
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>




<main role="main" class="flex-shrink-0">
    <div class="container-fluid">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-end"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
