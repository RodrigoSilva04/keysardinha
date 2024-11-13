<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        // Defina o layout a ser usado
        $this->layout = 'main-login';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $auth = Yii::$app->authManager;
            $roles = $auth->getRolesByUser(Yii::$app->user->id);

            if (isset($roles['client'])) {
                // Desloga o usuário e redireciona ao frontend caso ele seja "client"
                Yii::$app->user->logout();
                // Manda o httprequest invalid e manda para o frontend passado 5s
                Yii::$app->session->setFlash('error', 'Usuário não autorizado a acessar o backoffice.');
                return $this->goHome(); // Redireciona ao frontend (ou outro destino)
            }

            // Verifica se o utilizador está bloqueado (não está completa a funcionalidade)
            $user = Yii::$app->user->identity;

            // Verifica se a identidade do usuário está carregada corretamente
            if ($user === null) {
                Yii::$app->session->setFlash('error', 'Erro ao carregar a identidade do usuário.');
                return $this->goHome(); // Redireciona ao frontend ou página de erro
            }

            // Agora, podemos verificar o status com segurança
            if ($user->status == 11) {
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('error', 'Utilizador bloqueado.');
                return $this->goHome(); // Redireciona ao frontend ou página de erro
            }

            // Se o usuário não for bloqueado, permite o acesso ao backend
            return $this->goBack();
        }

        // Limpa a senha do modelo de login por segurança
        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }


    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
