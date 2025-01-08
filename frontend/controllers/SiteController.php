<?php

namespace frontend\controllers;

use common\models\Categoria;
use common\models\Favoritos;
use common\models\Produto;
use common\models\Utilizadorperfil;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use yii\db\Expression;
use yii\httpclient\Client;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        // Obter os jogos mais jogados e criar produtos no banco de dados
        $jogosmaisjogados = $this->obterJogosMaisJogadosSteamAPI();

        // Buscar os produtos criados no banco de dados
        $produtos = Produto::find()->all();

        $produtostendencias = Produto::find()
            ->select(['produto.*', new Expression('SUM(linhafatura.quantidade) AS total_comprado')]) // Inclui colunas do modelo e soma quantidades
            ->innerJoin('linhafatura', 'produto.id = linhafatura.produto_id') // Relaciona com a tabela `linhafatura`
            ->groupBy('produto.id') // Agrupa por ID do produto
            ->orderBy(['total_comprado' => SORT_DESC]) // Ordena pelos mais comprados
            ->limit(4) // Limita aos 4 primeiros
            ->all(); // Retorna objetos do modelo Produto

        $categorias = Categoria::find()->all();
        $top3categorias = Categoria::find()->limit(3)->all();

        $this->layout = 'indexlay';

        return $this->render('index', [
            'produtos' => $produtos,
            'categorias' => $categorias,
            'top3categorias' => $top3categorias,
            'jogosmaisjogados' => $jogosmaisjogados,
            'produtostendencias' => $produtostendencias
        ]);
    }



    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //Vai para site/index
            Yii::$app->session->setFlash('success', 'Operação concluída com sucesso!');
            return $this->redirect(['site/index']);
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['site/index']);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Obrigado pelo teu registo. Verifica a tua caixa de entrada do email.');
            return $this->redirect(['site/index']);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->redirect(['site/index']);
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->redirect(['site/index']);
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
    public function obterJogosMaisJogadosSteamAPI()
    {
        $keyapi = "1BAEA13D3135D728476B8C8DE51B1CD4";
        $url = "https://api.steampowered.com/ISteamChartsService/GetMostPlayedGames/v1/";

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->setData(['key' => $keyapi])
            ->send();

        if ($response->statusCode == 200) {
            $ranks = $response->data['response']['ranks'];
            $topJogos = array_slice($ranks, 0, 6); // Filtra os 6 primeiros jogos
            $produtosCriados = [];

            foreach ($topJogos as $rank) {
                $appid = $rank['appid'];

                // Obter nome do jogo pela API Steam
                $nomeJogo = $this->obternomeporsteamid($appid);

                // Verificar se já existe um produto com este nome
                $produtoExistente = Produto::find()->where(['nome' => $nomeJogo])->one();

                if (!$produtoExistente) {
                    // Criar novo produto no banco de dados
                    $produto = new Produto();
                    $produto->nome = $nomeJogo;
                    $produto->descricao = "Jogo popular na Steam"; // Alterar conforme necessário
                    $produto->preco = "0.00"; // Alterar conforme necessário
                    $produto->imagem = "imagemdefault.jpg"; // Alterar conforme necessário
                    $produto->datalancamento = null; // Alterar conforme necessário
                    $produto->stockdisponivel = 0;
                    $produto->categoria_id = 1; // Ajustar para a categoria padrão
                    $produto->desconto_id = 1; // Ajustar para o desconto padrão
                    $produto->iva_id = 1; // Ajustar para o IVA padrão
                    $produto->save();

                    $produtosCriados[] = $produto;
                }else {
                    $produtosCriados[] = $produtoExistente;
                }
            }
            return $produtosCriados;
        } else {
            \Yii::error('Erro ao acessar a API da Steam: ' . $response->statusCode, __METHOD__);
        }
    }



    function obternomeporsteamid($appid)
    {
        $keyapi = "1BAEA13D3135D728476B8C8DE51B1CD4";
        $url = "https://store.steampowered.com/api/appdetails";

        // Solicita detalhes do jogo pelo appid da steam
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->setData([
                'appids' => $appid,
                'key' => $keyapi
            ])
            ->send();

        if ($response->statusCode == 200) {
            $appData = $response->data[$appid];
            if (isset($appData['data']['name'])) {
                return $appData['data']['name']; // Retorna o nome do jogo
            }
        }

        return "Nome não encontrado"; // Caso não encontre o nome
    }

    public function actionSearch()
    {
        $searchKeyword = Yii::$app->request->get('searchKeyword'); // Obtém o termo de pesquisa

        if ($searchKeyword) {
            // Procura o produto pelo nome
            $produto = Produto::find()
                ->where(['like', 'nome', $searchKeyword])
                ->one();

            if ($produto) {
                // Se encontrado, redireciona para a página de detalhes
                return $this->redirect(['produtos/view', 'id' => $produto->id]);
            }
        }

        // Se não encontrado, redireciona para a página de listagem de produtos
        return $this->redirect(['produtos/index']);
    }

    public function actionAddFavorite($produtoId)
    {
        $user = Yii::$app->user->identity; // Obtemos o usuário logado

        if (!$user) {
            Yii::$app->session->setFlash('error', 'Você precisa estar logado para adicionar aos favoritos.');
            return $this->redirect(['site/login']);
        }

        // Buscar o perfil do usuário logado
        $utilizadorPerfil = UtilizadorPerfil::findOne(['id' => $user->id]);

        if ($utilizadorPerfil === null) {
            Yii::$app->session->setFlash('error', 'Perfil não encontrado.');
            return $this->redirect(['site/index']);
        }

        // Agora temos o id do perfil
        $utilizadorPerfilId = $utilizadorPerfil->id;

        // Tenta adicionar aos favoritos
        if (Favoritos::addFavoritos($utilizadorPerfilId, $produtoId)) {
            Yii::$app->session->setFlash('success', 'Produto adicionado aos favoritos.');
        } else {
            Yii::$app->session->setFlash('info', 'Este produto já está nos favoritos.');
        }

        return $this->redirect(['produto/view', 'id' => $produtoId]);
    }

    // Ação para remover dos favoritos
    public function actionRemoveFavorite($produtoId)
    {
        $user = Yii::$app->user->identity; // Obtemos o usuário logado

        if (!$user) {
            Yii::$app->session->setFlash('error', 'Você precisa estar logado para remover dos favoritos.');
            return $this->redirect(['site/login']);
        }

        // Buscar o perfil do usuário logado
        $utilizadorPerfil = UtilizadorPerfil::findOne(['id' => $user->id]);

        if ($utilizadorPerfil === null) {
            Yii::$app->session->setFlash('error', 'Perfil não encontrado.');
            return $this->redirect(['site/index']);
        }

        // Agora temos o id do perfil
        $utilizadorPerfilId = $utilizadorPerfil->id;

        // Tenta remover dos favoritos
        if (Favoritos::removeFavoritos($utilizadorPerfilId, $produtoId)) {
            Yii::$app->session->setFlash('success', 'Produto removido dos favoritos.');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao remover o produto dos favoritos.');
        }

        return $this->redirect(['produto/view', 'id' => $produtoId]);
    }



}
