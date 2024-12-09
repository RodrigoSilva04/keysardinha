<?php
/* @var $content string */

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

// Defina os cards para o colaborador
// Definição dos cards para as roles 'colaborador' e 'admin' no backoffice


$cards = [
    'collaborator' => [
        [
            'title' => 'Gerir Jogos',
            'url' => Url::to(['game/index']),
            'image' => '../web/imagens/managegames.png',
            'description' => 'Adicione, edite ou remova jogos.',
            'permission' => 'manageGames',
        ],
        [
            'title' => 'Gerir chave de jogos',
            'url' => Url::to(['game/index']),
            'image' => '../web/imagens/gerirchavejogo.png',
            'description' => 'Adicione, edite ou remova chaves de jogos.',
            'permission' => 'manageGamesKey',
        ],
        [
            'title' => 'Gerir Promoções',
            'url' => Url::to(['promotions/index']),
            'image' => '../web/imagens/gerirpromocoes.png',
            'description' => 'Gerencie promoções e ofertas especiais.',
            'permission' => 'managePromotions',
        ],
        [
            'title' => 'Gerir Categorias',
            'url' => Url::to(['categories/index']),
            'image' => '../web/imagens/gerircategorias.png',
            'description' => 'Gerencie categorias de jogos.',
            'permission' => 'manageCategories',
        ],
        [
            'title' => 'Visualizar Estatísticas de Vendas',
            'url' => Url::to(['sales-statistics/index']),
            'image' => '../web/imagens/gerirestatsticas.png',
            'description' => 'Veja as estatísticas de vendas.',
            'permission' => 'viewSalesStatistics',
        ],

    ],
];

// Cards para o admin que herdam os cards do colaborador
$cards['admin'] = array_merge($cards['collaborator'], [
    [
        'title' => 'Gerir Utilizadores',
        'url' => Url::to(['user/index']),
        'image' => '../web/imagens/usermanageicon.png',
        'description' => 'Gere as roles de cada utilizador registado no nosso sistema.',
        'permission' => 'manageUsers',
    ],
    [
        'title' => 'Gerir Encomendas',
        'url' => Url::to(['orders/index']),
        'image' => '../web/imagens/gestaodeencomendas.png',
        'description' => 'Verifique as encomendas realizadas.',
        'permission' => 'viewOrders',
    ],
    [
        'title' => 'Gerir Métodos de Pagamento',
        'url' => Url::to(['payment-methods/index']),
        'image' => '../web/imagens/gerirmetodos.png',
        'description' => 'Gerencie os métodos de pagamento disponíveis.',
        'permission' => 'managePaymentMethods',
    ],
    [
        'title' => 'Gerar Relatórios',
        'url' => Url::to(['reports/index']),
        'image' => '../web/imagens/gerirrelatorios.png',
        'description' => 'Gere relatórios de vendas e outros dados.',
        'permission' => 'generateReports',
    ],
]);

$auth = Yii::$app->authManager;
$roles = $auth->getRolesByUser(Yii::$app->user->id);
$userRole = !empty($roles) ? key($roles) : null;
$userPermissions = array_keys($auth->getPermissionsByUser(Yii::$app->user->id));

$availableCards = $cards[$userRole] ?? [];

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

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <?php
                // Verificar se estamos na página do dashboard ou outras páginas do backoffice
                if ($this->context->id === 'site' && $this->context->action->id === 'index'):
                    ?>
                    <!-- Exibe os cards no dashboard -->
                    <?php if (!empty($availableCards)): ?>
                    <?php foreach ($availableCards as $card): ?>
                        <?php if (in_array($card['permission'], $userPermissions)): ?>
                            <div class="card" style="width: 18rem; margin: 10px;">
                                <img src="<?= Html::encode($card['image']) ?>" class="card-img-top" alt="<?= Html::encode($card['title']) ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= Html::encode($card['title']) ?></h5>
                                    <p class="card-text"><?= Html::encode($card['description']) ?></p>
                                    <a href="<?= Html::encode($card['url']) ?>" class="btn btn-primary">Ir para</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-warning" role="alert">
                        Não há opções disponíveis para a sua role.
                    </div>
                <?php endif; ?>
                <?php else: ?>
                    <!-- Aqui vai renderizar o conteúdo das outras páginas (por exemplo, a listagem de usuários em user/index) -->
                    <?= $content ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>
