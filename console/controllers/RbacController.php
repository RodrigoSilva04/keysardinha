<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll(); // Limpar todas as atribuições
        $auth->removeAllPermissions(); // Limpar todas as permissões

        // Adicionar permissões para o Cliente
        $viewGame = $auth->createPermission('viewGame');
        $viewGame->description = 'View game details';
        $auth->add($viewGame);

        $addToFavorites = $auth->createPermission('addToFavorites');
        $addToFavorites->description = 'Add games to favorites';
        $auth->add($addToFavorites);

        $addToCart = $auth->createPermission('addToCart');
        $addToCart->description = 'Add games to cart';
        $auth->add($addToCart);

        $removeFromCart = $auth->createPermission('removeFromCart');
        $removeFromCart->description = 'Remove games from cart';
        $auth->add($removeFromCart);

        $checkout = $auth->createPermission('checkout');
        $checkout->description = 'Checkout';
        $auth->add($checkout);

        $applyDiscount = $auth->createPermission('applyDiscount');
        $applyDiscount->description = 'Apply discount coupons';
        $auth->add($applyDiscount);

        // Adicionar permissões para o Colaborador
        $manageGames = $auth->createPermission('manageGames');
        $manageGames->description = 'Manage games';
        $auth->add($manageGames);

        $managePromotions = $auth->createPermission('managePromotions');
        $managePromotions->description = 'Manage promotions';
        $auth->add($managePromotions);

        $manageCategories = $auth->createPermission('manageCategories');
        $manageCategories->description = 'Manage game categories';
        $auth->add($manageCategories);

        $viewSalesStatistics = $auth->createPermission('viewSalesStatistics');
        $viewSalesStatistics->description = 'View sales statistics';
        $auth->add($viewSalesStatistics);

        // Adicionar permissões para o Administrador
        $manageUsers = $auth->createPermission('manageUsers');
        $manageUsers->description = 'Manage users';
        $auth->add($manageUsers);

        $viewOrders = $auth->createPermission('viewOrders');
        $viewOrders->description = 'View orders';
        $auth->add($viewOrders);

        $managePaymentMethods = $auth->createPermission('managePaymentMethods');
        $managePaymentMethods->description = 'Manage payment methods';
        $auth->add($managePaymentMethods);

        $generateReports = $auth->createPermission('generateReports');
        $generateReports->description = 'Generate sales reports';
        $auth->add($generateReports);

        // Criação das roles
        $client = $auth->createRole('client');
        $auth->add($client);

        $collaborator = $auth->createRole('collaborator');
        $auth->add($collaborator);

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        // Atribuir permissões às roles
        $auth->addChild($client, $viewGame);
        $auth->addChild($client, $addToFavorites);
        $auth->addChild($client, $addToCart);
        $auth->addChild($client, $removeFromCart);
        $auth->addChild($client, $checkout);
        $auth->addChild($client, $applyDiscount);

        $auth->addChild($collaborator, $manageGames);
        $auth->addChild($collaborator, $managePromotions);
        $auth->addChild($collaborator, $manageCategories);
        $auth->addChild($collaborator, $viewSalesStatistics);

        $auth->addChild($admin, $manageUsers);
        $auth->addChild($admin, $viewOrders);
        $auth->addChild($admin, $managePaymentMethods);
        $auth->addChild($admin, $generateReports);
        $auth->addChild($admin, $collaborator); // Administrador herda permissões do colaborador

        // Limpar todas as atribuições

        // Atribuir roles aos usuários. 1 e 2 são IDs retornados por IdentityInterface::getId()
        $auth->assign($collaborator, 1); // Atribuindo a role Collaborator ao usuário com ID 2
        $auth->assign($admin, 2); // Atribuindo a role Administrator ao usuário com ID 1
        $auth->assign($client, 3); // Atribuindo a role Client ao usuário com ID 3


    }
}
