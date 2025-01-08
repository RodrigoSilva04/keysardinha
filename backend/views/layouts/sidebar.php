<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../../frontend/web/site/index" class="brand-link">
        <img src="<?= Yii::getAlias('@web') ?>/logokeysardinha.webp" alt="Keysardinha Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">KeySardinha</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                    <a href="#" class="d-block"><?= \Yii::$app->user->identity->username .'('. Yii::$app->user->identity->getRole() .')'?> </a><!-- Vai buscar o nome de utilizador e mostra -->
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    [
                        'label' => 'Gerir jogos e categorias',
                        'icon' => 'tachometer-alt',
                        'badge' => '<span class="right badge badge-info">2</span>',
                        'items' => [
                            ['label' => 'Gerir jogos', 'url' => ['produto/index'], 'iconStyle' => 'far'],
                            ['label' => 'Gerir categorias', 'url' => ['categoria/index'],'iconStyle' => 'far'],
                        ]
                    ],
                    ['label' => 'Gerir chaves de jogos', 'url' => ['chavedigital/index'], 'icon' => 'th', 'badge' => '<span class="right badge badge-danger">New</span>'],
                    ['label' => 'Yii2 PROVIDED', 'header' => true],
                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                    ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
                    ['label' => 'Promoções e vendas', 'header' => true],
                    ['label' => 'Gerir metodos de pagamento', 'url' => ['metodopagamento/index'], 'iconStyle' => 'far'],
                    ['label' => 'Gerir Promoções' , 'url' => ['descontos/index']],
                    [
                        'label' => 'Relatórios e estatísticas',
                        'items' => [
                            ['label' => 'Relatório de vendas', 'iconStyle' => 'far'],
                            ['label' => 'Estatisticas de vendas', 'iconStyle' => 'far']
                        ]
                    ],
                    ['label' => 'Gerir Encomendas' , 'url' => ['fatura/index']],
                    ['label' => 'Erros e problemas', 'header' => true],
                    ['label' => 'Erros criticos', 'iconStyle' => 'far', 'iconClassAdded' => 'text-danger'],
                    ['label' => 'Erros médios', 'iconClass' => 'nav-icon far fa-circle text-warning'],
                    ['label' => 'Erros leves', 'iconStyle' => 'far', 'iconClassAdded' => 'text-info'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>