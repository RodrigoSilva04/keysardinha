<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Fatura;
use common\models\Linhafatura;
use Yii;
use yii\rest\ActiveController;

class FaturaController extends ActiveController
{
    public $modelClass = 'common\models\Fatura';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }
    public function actionIndex()
    {
        // Obtém o ID do utilizador logado
        $utilizadorId = Yii::$app->user->identity->id;

        //Encontra todas as faturas do utilizador
        $faturas = Fatura::find()
            ->where(['utilizadorperfil_id' => $utilizadorId])
            ->all();

        // Verifica se existem faturas
        if (empty($faturas)) {
            Yii::$app->response->statusCode = 404; // Código de não encontrado
            return [
                'status' => 'error',
                'message' => 'Nenhuma fatura encontrada para este utilizador.',
            ];
        }

        // Retorna as faturas encontradas
        Yii::$app->response->statusCode = 200; //sucesso
        return [
            'status' => 'success',
            'message' => 'Faturas recuperadas com sucesso.',
            'faturas' => $faturas, // Retorna os dados das faturas
        ];
    }

    public function actionView($id)
    {
        // Obtem a fatura pelo ID
        $fatura = Fatura::findOne($id);

        // Verifica se a fatura existe
        if (!$fatura) {
            Yii::$app->response->statusCode = 404;
            return [
                'status' => 'error',
                'message' => 'Fatura não encontrada.',
            ];
        }

        // Busca as linhas da fatura associadas
        $linhasFatura = Linhafatura::find()
            ->where(['fatura_id' => $id])
            ->all();

        // Retorna os detalhes da fatura e suas linhas
        Yii::$app->response->statusCode = 200;
        return [
            'status' => 'success',
            'message' => 'Fatura encontrada com sucesso.',
            'fatura' => $fatura,
            'linhasFatura' => $linhasFatura,
        ];
    }

    public function actionCreate()
    {
        $model = new Fatura();

        // Verifica se a requisição é POST
        if (Yii::$app->request->isPost) {
            // Carrega os dados recebidos no modelo
            $data = Yii::$app->request->post();
            $model->load($data, '');

            // Define o ID do utilizador logado como proprietário da fatura
            $model->utilizadorperfil_id = Yii::$app->user->id;
            $model->datafatura = date('Y-m-d H:i:s'); // Define a data atual

            // Tenta salvar o modelo
            if ($model->save()) {
                Yii::$app->response->statusCode = 201; // Código de criado
                return [
                    'status' => 'success',
                    'message' => 'Fatura criada com sucesso.',
                    'fatura' => $model,
                ];
            } else {
                Yii::$app->response->statusCode = 400; // Código de solicitação inválida
                return [
                    'status' => 'error',
                    'message' => 'Erro ao criar a fatura.',
                    'errors' => $model->errors,
                ];
            }
        }

        // Retorna um erro se não for uma requisição POST
        Yii::$app->response->statusCode = 405; // Método não permitido
        return [
            'status' => 'error',
            'message' => 'Método não permitido. Use POST para criar uma fatura.',
        ];
    }

    public function actionUpdate($id)
    {
        // Busca a fatura correspondente ao ID informado
        $model = Fatura::findOne(['id' => $id, 'utilizadorperfil_id' => Yii::$app->user->id]);

        if (!$model) {
            Yii::$app->response->statusCode = 404; //Fatura não encontrada
            return [
                'status' => 'error',
                'message' => 'Fatura não encontrada ou você não tem permissão para editá-la.',
            ];
        }

        // Verifica se é uma requisição PUT ou PATCH
        if (Yii::$app->request->isPut || Yii::$app->request->isPatch) {
            $data = Yii::$app->request->bodyParams;

            // carrega os novos dados no modelo
            if ($model->load($data, '') && $model->save()) {
                Yii::$app->response->statusCode = 200; // Atualização bem-sucedida
                return [
                    'status' => 'success',
                    'message' => 'Fatura atualizada com sucesso.',
                    'fatura' => $model,
                ];
            } else {
                Yii::$app->response->statusCode = 400; // Dados inválidos
                return [
                    'status' => 'error',
                    'message' => 'Erro ao atualizar a fatura.',
                    'errors' => $model-> errors,
                ];
            }
        }

        // Retorna um erro se o método HTTP for inválido
        Yii::$app->response->statusCode = 405; // Método não permitido
        return [
            'status' => 'error',
            'message' => 'Método não permitido. Use PUT ou PATCH para atualizar uma fatura.',
        ];
    }

    public function actionDelete($id)
    {
        //Busca a fatura correspondente ao ID informado
        $model = Fatura::findOne(['id' => $id, 'utilizadorperfil_id' => Yii::$app->user->id]);

        if (!$model) {
            Yii::$app->response-> statusCode = 404; // Fatura não encontrada
            return [
                'status' => 'error',
                'message' => 'Fatura não  encontrada ou você não tem permissão para excluí-la.',
            ];
        }

        // Tenta excluir a fatura
        if ($model->delete() !== false) {
            Yii::$app->response->statusCode = 200; // Exclusão bem-sucedida
            return [
                'status' => 'success',
                'message' => 'Fatura excluída com sucesso.',
            ];
        } else {
            Yii::$app->response->statusCode = 500; // Erro interno no servidor
            return [
                'status' => 'error',
                'message' => 'Erro ao tentar excluir a fatura. Tente novamente mais tarde.',
            ];
        }
    }


}
