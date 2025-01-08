<?php

namespace frontend\controllers;

use common\models\Fatura;
use common\models\User;
use Yii;
use common\models\Utilizadorperfil;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PerfilController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index', 'update'], // Ações protegidas
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index','update'], // Permitir acesso às ações 'index' e 'view'
                            'roles' => ['@'], // Apenas para utilizadores autenticados
                        ],
                        [
                            'allow' => false, // Bloquear todas as outras tentativas de acesso
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'], // Apenas POST permitido para 'delete'
                    ],
                ],
            ]
        );
    }
    public function actionIndex()
    {
        // Obter o ID do utilizador logado
        $userId = Yii::$app->user->identity->id;

        // Encontrar o perfil e o utilizador
        $perfil = Utilizadorperfil::findOne($userId);
        $user = User::findOne($userId);
        $faturas = Fatura::findAll(['utilizadorperfil_id' => $userId]);

        if (!$perfil || !$user) {
            throw new NotFoundHttpException('Perfil ou utilizador não encontrado.');
        }

        return $this->render('index', [
            'perfil' => $perfil,
            'user' => $user,
            'faturas' => $faturas,
        ]);
    }

    public function actionUpdate()
    {
        // Obter o ID do utilizador logado
        $userId = Yii::$app->user->identity->id;

        // Encontrar o perfil do utilizador
        $perfil = Utilizadorperfil::findOne($userId);
        $user = User::findOne($userId); // Buscar o modelo User

        if (!$perfil || !$user) {
            throw new NotFoundHttpException('Perfil ou utilizador não encontrado.');
        }

        // Verificar se os dados de ambos os modelos foram carregados
        if ($perfil->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post()))
        {
            // Validar e salvar os dados dos modelos
            if ($perfil->save() && $user->save()) {
                Yii::$app->session->setFlash('success', 'Perfil atualizado com sucesso.');
                return $this->redirect(['index']); // Redireciona para a página inicial ou para outro local
            } else {
                // Caso falhe ao salvar, você pode retornar com erros
                Yii::$app->session->setFlash('error', 'Falha ao atualizar o perfil.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Falha ao atualizar o perfil. Não tem model ou post.');
        }

        // Renderizar a view do formulário de atualização
        return $this->render('update', [
            'perfil' => $perfil,
            'user' => $user,
        ]);
    }
}