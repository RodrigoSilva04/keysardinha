<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use Yii;
use common\models\UtilizadorPerfil; // Modelo UtilizadorPerfil

class UtilizadorPerfilController extends ActiveController
{
    public $modelClass = 'common\models\UtilizadorPerfil';

    // Ver perfil do utilizador
    public function actionView()
    {
        // Recupera o perfil do utilizador com base no ID
        $utilizadorPerfil = UtilizadorPerfil::findOne(Yii::$app->user->id);

        // Verifica se o perfil foi encontrado
        if (!$utilizadorPerfil) {
            return Yii::$app->response->setStatusCode(404)
                ->data = [
                'status' => 'error',
                'message' => 'Perfil não encontrado.'
            ];
        }

        // Retorna o perfil do utilizador com um código de sucesso
        return Yii::$app->response->setStatusCode(200)
            ->data = [
            'status' => 'success',
            'message' => 'Perfil recuperado com sucesso.',
            'utilizadorPerfil' => $utilizadorPerfil
        ];
    }

    // Criar perfil do utilizador
    public function actionCreate()
    {
        $model = new UtilizadorPerfil(); // Criar um novo perfil

        // Verifica se os dados da requisição foram carregados corretamente
        if ($model->load(Yii::$app->request->post())) {
            // Tentativa de salvar o novo perfil de utilizador
            if ($model->save()) {
                // Se o perfil for criado com sucesso
                Yii::$app->session->setFlash('success', 'Usuário criado com sucesso.');

                // Redireciona para a lista de utilizadores ou outra página relevante
                return $this->redirect(['index']); // Você pode ajustar essa rota conforme necessário
            } else {
                // Se ocorrer um erro ao salvar o perfil
                Yii::$app->session->setFlash('error', 'Erro ao criar o usuário. Tente novamente.');
            }
        }

        // Renderiza a página de criação com o modelo vazio
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    // Atualiza perfil do utilizador
    public function actionUpdate()
    {
        // Encontra o perfil do utilizador com base no ID
        $utilizadorPerfil = UtilizadorPerfil::findOne(Yii::$app->user->id);

        if (!$utilizadorPerfil) {
            return Yii::$app->response->setStatusCode(404)
                ->data = [
                'status' => 'error',
                'message' => 'Perfil não encontrado.'
            ];
        }

        // Atualiza os dados do perfil com os dados enviados via PUT
        $utilizadorPerfil->load(Yii::$app->request->post(), '');

        if ($utilizadorPerfil->save()) {
            return Yii::$app->response->setStatusCode(200)
                ->data = [
                'status' => 'success',
                'message' => 'Perfil atualizado com sucesso.',
                'utilizadorPerfil' => $utilizadorPerfil
            ];
        }

        return Yii::$app->response->setStatusCode(400)
            ->data = [
            'status' => 'error',
            'message' => 'Erro ao atualizar perfil.',
            'errors' => $utilizadorPerfil->errors
        ];
    }

    // Deletar perfil do utilizador
    public function actionDelete()
    {
        // Encontra o perfil do utilizador com base no ID
        $utilizadorPerfil = UtilizadorPerfil::findOne(Yii::$app->user->id);

        if (!$utilizadorPerfil) {
            return Yii::$app->response->setStatusCode(404)
                ->data = [
                'status' => 'error',
                'message' => 'Perfil não encontrado.'
            ];
        }

        // Deleta o perfil do utilizador
        if ($utilizadorPerfil->delete()) {
            return Yii::$app->response->setStatusCode(200)
                ->data = [
                'status' => 'success',
                'message' => 'Perfil deletado com sucesso.'
            ];
        }

        return Yii::$app->response->setStatusCode(400)
            ->data = [
            'status' => 'error',
            'message' => 'Erro ao deletar perfil.'
        ];
    }
}
