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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/site.css') ?>">

    <?php $this->head() ?>
    <style>

    </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/logokeysardinha.webp', ['alt' => 'Logo', 'class' => 'logo ms-auto d-flex']),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark navbar-sticky',
        ],
    ]);

    $menuItems = [
        ['label' => 'Home', 'url' => ['/produto/index'], 'linkOptions' => ['class' => 'btn btn-primary buttonNavbar']],
        ['label' => 'About', 'url' => ['/site/about'], 'linkOptions' => ['class' => 'btn btn-secondary buttonNavbar']],
        ['label' => 'Contact', 'url' => ['/site/contact'], 'linkOptions' => ['class' => 'btn btn-info buttonNavbar']],
        ['label' => 'Jogos', 'url' => ['/produto/index'], 'linkOptions' => ['class' => 'btn btn-warning buttonNavbar']],
        ['label' => 'Favoritos', 'url' => ['/favoritos/index'], 'linkOptions' => ['class' => 'btn btn-success buttonNavbar']],
    ];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
        'items' => $menuItems,
    ]);
    ?>

    <!-- Barra de pesquisa ajustada -->
        <!-- Barra de pesquisa ajustada com apenas a lupa -->
        <div class="search-container">
            <?php
            echo Html::beginForm(['produto/search'], 'get', ['class' => 'input-group search-form']);
            ?>
            <div class="form-outline position-relative">
                <?php
                echo Html::textInput('query', null, [
                    'class' => 'form-control search-input',
                    'id' => 'form1',
                    'placeholder' => 'Pesquisar jogos...',
                ]);
                ?>
                <i class="fas fa-search position-absolute"
                   style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
            </div>
            <?php
            echo Html::endForm();
            ?>
        </div>

    <div class="opcoes-login"
    <!-- Se o usuário for um guest, exibe login e signup -->
    <?php if (Yii::$app->user->isGuest): ?>
        <div class="d-flex ms-5">
            <?= Html::a('Login', ['/site/login'], ['class' => ['btn button-login']]) ?>
            <?= Html::a('Signup', ['/site/signup'], ['class' => ['btn button-signup']]) ?>
        </div>
    <?php else: ?>
        <!-- Se o usuário estiver logado, exibe um dropdown com nome e logout -->
        <li class="nav-item dropdown">
            <!-- Botão branco com o nome do usuário -->
            <?= Html::a(
                Yii::$app->user->identity->username, // Nome do utilizador
                '#', // URL do link
                [
                    'class' => 'btn btn-light dropdown-toggle profile-name', // Botão branco (classe 'btn-light' para fundo branco)
                    'id' => 'navbarDropdown',
                    'role' => 'button',
                    'data-bs-toggle' => 'dropdown',
                    'aria-expanded' => 'false',
                ]
            ) ?>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><?= Html::a('Perfil', ['/site/profile'], ['class' => 'dropdown-item']) ?></li>
                <li><?= Html::a('Carrinho', ['/site/carrinho'], ['class' => 'dropdown-item']) ?></li>
                <li><?= Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex ms-3']) .
                    Html::submitButton('Logout', ['class' => 'dropdown-item text-decoration-none']) .
                    Html::endForm() ?>
                </li>
            </ul>
        </li>

        </ul>
        </li>
    <?php endif; ?>
    </div>

    <?php NavBar::end(); ?>
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
