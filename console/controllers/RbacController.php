<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        //Sempre que for executado para adicionar alguma permissao
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

        // Adicionar permissões CRUD para o Colaborador


        //CRUD de jogos
        $createGame = $auth->createPermission('createGame');
        $createGame->description = 'Create a game';
        $auth->add($createGame);

        $readGame = $auth->createPermission('readGame');
        $readGame->description = 'Read game details';
        $auth->add($readGame);

        $updateGame = $auth->createPermission('updateGame');
        $updateGame->description = 'Update a game';
        $auth->add($updateGame);

        $deleteGame = $auth->createPermission('deleteGame');
        $deleteGame->description = 'Delete a game';
        $auth->add($deleteGame);

        //CRUD Chavedigital
        $createGameKey = $auth->createPermission('createGameKey');
        $createGameKey->description = 'Create a game key';
        $auth->add($createGameKey);

        $readGameKey = $auth->createPermission('readGameKey');
        $readGameKey->description = 'Read game key details';
        $auth->add($readGameKey);

        $updateGameKey = $auth->createPermission('updateGameKey');
        $updateGameKey->description = 'Update a game key';
        $auth->add($updateGameKey);

        $deleteGameKey = $auth->createPermission('deleteGameKey');
        $deleteGameKey->description = 'Delete a game key';
        $auth->add($deleteGameKey);


        //CRUD categorias
        $createCategory = $auth->createPermission('createCategory');
        $createCategory->description = 'Create a category';
        $auth->add($createCategory);

        $readCategory = $auth->createPermission('readCategory');
        $readCategory->description = 'Read category details';
        $auth->add($readCategory);

        $updateCategory = $auth->createPermission('updateCategory');
        $updateCategory->description = 'Update a category';
        $auth->add($updateCategory);

        $deleteCategory = $auth->createPermission('deleteCategory');
        $deleteCategory->description = 'Delete a category';
        $auth->add($deleteCategory);

        $viewSalesStatistics = $auth->createPermission('viewSalesStatistics');
        $viewSalesStatistics->description = 'View sales statistics';
        $auth->add($viewSalesStatistics);

        $acessBackend = $auth->createPermission('acessBackend');
        $acessBackend->description = 'Access to backend';
        $auth->add($acessBackend);

        // Adicionar permissões CRUD para o Administrador

        //CRUD de utilizadores
        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Create a user';
        $auth->add($createUser);

        $readUser = $auth->createPermission('readUser');
        $readUser->description = 'Read user details';
        $auth->add($readUser);

        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'Update a user';
        $auth->add($updateUser);

        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Delete a user';
        $auth->add($deleteUser);

        $viewOrders = $auth->createPermission('viewOrders');
        $viewOrders->description = 'View orders';
        $auth->add($viewOrders);

        //Crud de metodos de pagamento
        $createPaymentMethod = $auth->createPermission('createPaymentMethod');
        $createPaymentMethod->description = 'Create a payment method';
        $auth->add($createPaymentMethod);

        $readPaymentMethod = $auth->createPermission('readPaymentMethod');
        $readPaymentMethod->description = 'Read payment method details';
        $auth->add($readPaymentMethod);

        $updatePaymentMethod = $auth->createPermission('updatePaymentMethod');
        $updatePaymentMethod->description = 'Update a payment method';
        $auth->add($updatePaymentMethod);

        $deletePaymentMethod = $auth->createPermission('deletePaymentMethod');
        $deletePaymentMethod->description = 'Delete a payment method';
        $auth->add($deletePaymentMethod);

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
        $auth->addChild($client, $readGame); // Cliente pode visualizar jogos
        $auth->addChild($client, $addToFavorites); // Permissão para adicionar jogos aos favoritos
        $auth->addChild($client, $addToCart); // Permissão para adicionar itens ao carrinho
        $auth->addChild($client, $removeFromCart); // Permissão para remover itens do carrinho
        $auth->addChild($client, $checkout); // Permissão para realizar checkout
        $auth->addChild($client, $applyDiscount); // Permissão para aplicar descontos

        // Permissões para o Colaborador
        $auth->addChild($collaborator, $createGame); // Colaborador pode adicionar jogos
        $auth->addChild($collaborator, $readGame); // Colaborador pode ver jogos
        $auth->addChild($collaborator, $updateGame); // Colaborador pode atualizar jogos
        $auth->addChild($collaborator, $deleteGame); // Colaborador pode remover jogos

        $auth->addChild($collaborator, $createGameKey); // Colaborador pode adicionar chaves digitais
        $auth->addChild($collaborator, $readGameKey); // Colaborador pode ver chaves digitais
        $auth->addChild($collaborator, $updateGameKey); // Colaborador pode atualizar chaves digitais
        $auth->addChild($collaborator, $deleteGameKey); // Colaborador pode remover chaves digitais

        $auth->addChild($collaborator, $createCategory); // Colaborador pode adicionar categorias
        $auth->addChild($collaborator, $readCategory); // Colaborador pode ver categorias
        $auth->addChild($collaborator, $updateCategory); // Colaborador pode atualizar categorias
        $auth->addChild($collaborator, $deleteCategory); // Colaborador pode remover categorias

        $auth->addChild($collaborator, $viewSalesStatistics); // Permissão para ver as estatísticas de vendas
        $auth->addChild($collaborator, $acessBackend); // Acesso ao backend

        // Permissões para o Administrador
        $auth->addChild($admin, $createUser); // Administrador pode adicionar utilizadores
        $auth->addChild($admin, $readUser); // Administrador pode ver utilizadores
        $auth->addChild($admin, $updateUser); // Administrador pode atualizar utilizadores
        $auth->addChild($admin, $deleteUser); // Administrador pode remover utilizadores

        $auth->addChild($admin, $viewOrders); // Permissão para ver pedidos

        $auth->addChild($admin, $createPaymentMethod); // Administrador pode adicionar métodos de pagamento
        $auth->addChild($admin, $readPaymentMethod); // Administrador pode ver métodos de pagamento
        $auth->addChild($admin, $updatePaymentMethod); // Administrador pode atualizar métodos de pagamento
        $auth->addChild($admin, $deletePaymentMethod); // Administrador pode remover métodos de pagamento

        $auth->addChild($admin, $generateReports); // Permissão para fazer relatórios
        $auth->addChild($admin, $collaborator); // Administrador herda permissões do colaborador

        // Atribuir roles aos utilizadores. 1 e 2 e 3 são IDs retornados por IdentityInterface::getId()
        $auth->assign($collaborator, 1); // Atribuindo a role Collaborator ao usuário com ID 1
        $auth->assign($admin, 2); // Atribuindo a role Administrator ao usuário com ID 2
        $auth->assign($client, 3); // Atribuindo a role Client ao usuário com ID 3


    }
}
