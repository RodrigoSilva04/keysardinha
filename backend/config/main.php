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
                    'pluralize' => false, // Evitar o plural
                ],
                // Carrinho de compras
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/carrinho',
                    'extraPatterns' => [
                        'GET findcarrinho' => 'findcarrinho', // Ver carrinho.
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
                        'GET findfatura' => 'findfatura',// Ver todas as faturas do utilizador
                        'GET {id}' => 'view', // Ver detalhes de uma fatura específica.                        'PUT update/{id}' => 'update', // Atualizar item no carrinho
                        'POST create' => 'create',         // Criar uma nova fatura.
                        'PUT update/{id}' => 'update',     // Atualizar uma fatura existente.
                        'DELETE delete/{id}' => 'delete', // Apagar uma fatura.
                    ],
                    'pluralize' => false, // Evitar o plural
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
                    'pluralize' => false, // Evitar o plural
                ],

                //Chaves digitais
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/chavedigital',
                    'extraPatterns' => [
                         // Lista todas as chaves digitais
                        'GET index' => 'index',
                        'GET view' => 'view', // Mostra detalhes de uma chave digital específica
                        'POST chavedigital' => 'create', // Cria nova chave digital
                        'PUT chavedigital' => 'update', // Atualiza uma chave digital existente
                        'DELETE chavedigital' => 'delete', // Deleta uma chave digital
                    ],
                    'pluralize' => false, // Evitar o plural
                ],

                // Perfil do utilizador
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/user',
                    'extraPatterns' => [
                        'GET view' => 'view',// Ver perfil do utilizador.
                        'POST user' => 'create',// Cria perfil
                        'PUT user' => 'update', // Atualiza perfil
                        'DELETE user' => 'delete',    // apagar perfil
                        'POST login' => 'login', // Ação de login
                        'POST signup' => 'signup', // Ação de signup
                    ],
                    'pluralize' => false, // Evitar o plural
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
                    'pluralize' => false, // Evitar o plural
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/cupao',
                    'extraPatterns' => [
                        'GET view' => 'view',
                        'POST cupao' => 'create',
                        'PUT cupao' => 'update',
                        'DELETE cupao' => 'delete',
                        'GET count' => 'count',
                        'GET search' => 'search',
                        'GET {id}/detalhes' => 'detalhes',
                    ],
                    'pluralize' => false, // Evitar o plural
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/metodopagamento',
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'GET view' => 'view',
                        'POST create' => 'create',
                        'PUT update/{id}' => 'update',
                        'DELETE delete' => 'delete',
                    ],
                    'pluralize' => false, // Evitar o plural
                ],
                [
                'class' => 'yii\rest\UrlRule',
                'controller' => 'api/comentario',
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'GET view' => 'view',
                        'POST comentario' => 'create',
                        'PUT comentario' => 'update',
                        'DELETE comentario' => 'delete',
                    ],
                    'pluralize' => false, // Evitar o plural
            ]


            ], //End rules

        ],

    ],
    'params' => $params,
];
