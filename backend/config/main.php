<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\ModuleAPI',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/produto', // Controlador de produtos
                'extraPatterns' => [
                    'GET index' => 'index', //Lista todos os produtos
                    'GET view' => 'view', // Mostra todos os produtos
                    'POST produto' => 'create',// Cria produto
                    'PUT produto' => 'update', // Atualiza produto
                    'DELETE produto' => 'delete',    // apagar produto
                    'GET count' => 'count',  // Conta quanto jogos há
                    'GET search' => 'search', // Pesquisar jogos.
                    'GET filter' => 'filter',  // Filtrar por categoria.
                    'GET {id}/detalhes' => 'detalhes', // Ver detalhes de um jogo
                    ],
                ],
                // Carrinho de compras
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/carrinho',
                    'extraPatterns' => [
                        'GET view' => 'view',// Ver carrinho.
                        'POST add' => 'add',  // Adicionar item ao carrinho.
                        'PUT update/{id}' => 'update', // Atualizar item no carrinho
                        'DELETE remove/{id}' => 'remove',  // Remover item do carrinho.
                        'POST checkout' => 'checkout',  // Finalizar a compra.
                        'POST verificar-cupao' => 'verificar-cupao', // Aplicar cupao no carrinho.
                    ],
                    'pluralize' => false, // Evitar o plural
                ],

                // Faturas
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/fatura',
                    'extraPatterns' => [
                        'GET index' => 'index',// Ver todas as faturas do utilizador
                        'GET {id}' => 'view', // Ver detalhes de uma fatura específica.                        'PUT update/{id}' => 'update', // Atualizar item no carrinho
                        'POST create' => 'create',         // Criar uma nova fatura.
                        'PUT update/{id}' => 'update',     // Atualizar uma fatura existente.
                        'DELETE delete/{id}' => 'delete', // Apagar uma fatura.
                    ],
                ],

                // Favoritos
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/favoritos',
                    'extraPatterns' => [
                        'GET index' => 'index', //Lista todos os favoritos do user
                        'POST add' => 'add', // Adicionar aos favoritos.
                        'DELETE remove/{id}' => 'remove',  // Remover dos favoritos.
                        'GET offline' => 'offline',  // Gerir favoritos offline.
                    ],
                ],

                //Chaves digitais
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/chavedigital',
                    'extraPatterns' => [
                        'GET index' => 'index', // Lista todas as chaves digitais
                        'GET view' => 'view', // Mostra detalhes de uma chave digital específica
                        'POST chavedigital' => 'create', // Cria nova chave digital
                        'PUT chavedigital' => 'update', // Atualiza uma chave digital existente
                        'DELETE chavedigital' => 'delete', // Deleta uma chave digital
                    ],
                ],

                // Perfil do utilizador
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/perfil',
                    'extraPatterns' => [
                        'GET view' => 'view',// Ver perfil do utilizador.
                        'POST perfil' => 'create',// Cria perfil
                        'PUT perfil' => 'update', // Atualiza perfil
                        'DELETE perfil' => 'delete',    // apagar perfil
                    ],
                ],

                // Controlador de categorias
                [
                'class' => 'yii\rest\UrlRule',
                'controller' => 'api/categoria',
                'extraPatterns' => [
                    'GET index' => 'index', // Lista todas as categorias
                    'GET view' => 'view', // Mostra detalhes de uma categoria específica
                    'POST categoria' => 'create', // Cria nova categoria
                    'PUT categoria' => 'update', // Atualiza uma categoria existente
                    'DELETE categoria' => 'delete', // Deleta uma categoria
                    ],
                ],

                // Métodos de pagamento
                // Ver fazer junto ou separado
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/pagamento',
                    'extraPatterns' => [
                        'GET metodos' => 'metodos',            // Listar métodos de pagamento.
                        'POST email-recibo' => 'email-recibo', // Enviar email com recibo.
                        'POST email-chave' => 'email-chave',   // Enviar chave do jogo.
                    ],
                ],


            ], //End rules

        ],

    ],
    'params' => $params,
];
