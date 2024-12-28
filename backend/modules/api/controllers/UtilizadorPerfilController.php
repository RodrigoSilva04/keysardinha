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
        $model = new UtilizadorPerfil();

        // Tenta carregar os dados enviados pela requisição POST
        $data = Yii::$app->request->post();
        if ($model->load($data, '') && $model->save()) {
            // Retorna o modelo criado como JSON, com o status HTTP 201 (Created)
            Yii::$app->response->statusCode = 201;
            return [
                'status' => 'success',
                'message' => 'Usuário criado com sucesso.',
                'data' => $model,
            ];
        }

        // Retorna os erros de validação com o status HTTP 422 (Unprocessable Entity)
        Yii::$app->response->statusCode = 422;
        return [
            'status' => 'error',
            'message' => 'Erro ao criar o usuário.',
            'errors' => $model->errors,
        ];
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
