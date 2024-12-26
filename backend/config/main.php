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
                    'GET count' => 'count',
                    'GET search' => 'search', // Pesquisar jogos.
                    'GET filter' => 'filter',  // Filtrar por categoria.
                    'GET {id}/detalhes' => 'detalhes', // Ver detalhes de um jogo.
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

                // Favoritos
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/favoritos',
                    'extraPatterns' => [
                        'POST add' => 'add', // Adicionar aos favoritos.
                        'DELETE remove/{id}' => 'remove',  // Remover dos favoritos.
                        'GET offline' => 'offline',  // Gerir favoritos offline.
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
                        'DELETE perfil' => 'delete',    // Atualizar perfil
                    ],
                ],

                // Métodos de pagamento e faturas
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
