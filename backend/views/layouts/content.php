<?php
/* @var $content string */

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

// Definindo as opções de cards disponíveis para cada role
$cards = [
    'admin' => [
        [
            'title' => 'Gerir Utilizadores',
            'url' => Url::to(['user/index']),
            'image' => 'path/to/user-image.jpg', // Substitua pelo caminho da imagem
            'description' => 'Gerencie os utilizadores do sistema.',
            'permission' => 'manageUsers', // Nome da permissão do RBAC
        ],
        [
            'title' => 'Gerir Produtos',
            'url' => Url::to(['product/index']),
            'image' => 'path/to/product-image.jpg', // Substitua pelo caminho da imagem
            'description' => 'Adicione, edite ou remova produtos.',
            'permission' => 'manageProducts', // Nome da permissão do RBAC
        ],
    ],
    'colaborador' => [
        [
            'title' => 'Gerir Jogos',
            'url' => Url::to(['game/index']),
            'image' => 'path/to/game-image.jpg', // Substitua pelo caminho da imagem
            'description' => 'Adicione, edite ou remova jogos.',
            'permission' => 'manageGames', // Nome da permissão do RBAC
        ],
        [
            'title' => 'Gerir Promoções',
            'url' => Url::to(['promotion/index']),
            'image' => 'path/to/promotion-image.jpg', // Substitua pelo caminho da imagem
            'description' => 'Crie e gerencie promoções para os jogos.',
            'permission' => 'managePromotions', // Nome da permissão do RBAC
        ],
        [
            'title' => 'Gerir Categorias',
            'url' => Url::to(['category/index']),
            'image' => 'path/to/category-image.jpg', // Substitua pelo caminho da imagem
            'description' => 'Adicione, edite ou remova categorias de jogos.',
            'permission' => 'manageCategories', // Nome da permissão do RBAC
        ],
        [
            'title' => 'Ver Estatísticas de Vendas',
            'url' => Url::to(['sales/index']),
            'image' => 'path/to/sales-image.jpg', // Substitua pelo caminho da imagem
            'description' => 'Visualize as estatísticas de vendas.',
            'permission' => 'viewSalesStatistics', // Nome da permissão do RBAC
        ],
    ],
];

// Obtendo as permissões do usuário logado
$auth = Yii::$app->authManager;
$userPermissions = $auth->getPermissionsByUser(Yii::$app->user->id);
$userRole = !empty($roles) ? key($roles) : null;

// Verificando se a role do usuário está nas opções de cards
$availableCards = $cards[$userRole] ?? [];

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <?= Html::encode($this->title ?? $this->context->id) ?>
                    </h1>
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
                <?php if (!empty($availableCards)): ?>
                    <?php foreach ($availableCards as $card): ?>
                        <?php if (in_array($card['permission'], array_keys($userPermissions))): ?>
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
            </div>
        </div>
    </div>
</div>
