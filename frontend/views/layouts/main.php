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
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/navbar.css') ?>">

    <?php $this->head() ?>
    <style>

    </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/logokeysardinha.webp', ['alt' => 'Logo', 'class' => 'logo']),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark navbar-sticky',
        ],
    ]);

    $menuItems = [
        ['label' => 'Home', 'url' => ['/produto/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
        ['label' => 'Jogos', 'url' => ['/produto/index']],
        ['label' => 'Favoritos', 'url' => ['/favoritos/index']],
        ['label' => 'Favoritos', 'url' => ['/favoritos/index']],
    ];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
        'items' => $menuItems,
    ]);
    ?>
    <!-- Seção para centralizar o texto KeySardinha -->

    <?php

    // Barra de pesquisa
    echo Html::beginForm(['produto/search'], 'get', ['class' => 'search-form']);
    echo Html::textInput('query', null, ['class' => 'form-control', 'placeholder' => 'Pesquisar jogos...']);
    echo Html::submitButton('Buscar', ['class' => 'btn btn-light']);
    echo Html::endForm();

     // Se o usuário for um guest, exibe login e signup
    if (Yii::$app->user->isGuest) {
        echo Html::tag('div',
            Html::a('Login', ['/site/login'], ['class' => ['btn btn-link login text-decoration-none']]),
            ['class' => 'd-flex ms-3']
        );
        echo Html::tag('div',
            Html::a('Signup', ['/site/signup'], ['class' => ['btn btn-link signup text-decoration-none']]),
            ['class' => 'd-flex ms-2']
        );
    } else {
        // Se o usuário estiver logado, exibe o botão de logout com nome
        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex ms-3'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout text-decoration-none']
            )
            . Html::endForm();
    }

    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
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
