<?php

namespace backend\modules\api\controllers;

use common\models\Mensagem;
use common\models\User;
use Yii;
use yii\rest\ActiveController;

class MensagemController extends ActiveController
{
    public $modelClass = 'common\models\Mensagem';

    public function actionSendMessage()
    {
        $mensagem = new Mensagem();

        // Obtém os dados enviados via POST
        $request = Yii::$app->request->post();

        // Valida se os campos "assunto", "corpo" e "user_id" estão presentes
        if (!isset($request['assunto']) || !isset($request['corpo']) || !isset($request['user_id'])) {
            return Yii::$app->response->setStatusCode(400)->data = [
                'status' => 'error',
                'message' => 'Os campos "assunto", "corpo" e "user_id" são obrigatórios.',
            ];
        }

        $user = User::findOne(['id' => ($request['user_id'])]);

        if ($user === null) {
            return Yii::$app->response->setStatusCode(400)->data = [
                'status' => 'error',
                'message' => 'User não encontrado.',
            ];
        }

        // Preenche os atributos da mensagem
        $mensagem->user_id = $request['user_id'];
        $mensagem->assunto = $request['assunto'];
        $mensagem->corpo = $request['corpo'];

        // Tenta salvar a mensagem no banco de dados
        if ($mensagem->save()) {

            return [
                'success' => true,
                'message' => 'Mensagem enviada com sucesso.',
            ];
        } else {
            // Retorna erros de validação
            return [
                'success' => false,
                'message' => 'Erro ao enviar a mensagem.',
                'errors' => $mensagem->errors,
            ];
        }
    }
    public function actionContadorMensagem($id)
    {
        // Verifica se o user existe
        $user = User::findOne(['id' => $id]);
        if ($user === null) {
            Yii::$app->response->statusCode = 404; // Define o status como 404
            return [
                'success' => false,
                'message' => 'Usuário não encontrado.',
            ];
        }

        // Conta o número de mensagens do user
        $contadorMensagem = Mensagem::find()->where(['user_id' => $id])->count();

        // Retorna o número de mensagens em formato JSON
        Yii::$app->response->statusCode = 200; // Define o status como 200
        return [
            'success' => true,
            'contador' => $contadorMensagem,
        ];
    }

    public function actionMostrarMensagens($id)
    {
        // Verifica se o user existe
        $user = User::findOne(['id' => $id]);
        if ($user === null) {
            Yii::$app->response->statusCode = 404; // Define o status como 404
            return [
                'success' => false,
                'message' => 'Usuário não encontrado.',
            ];
        }

        $mensagens = Mensagem::findAll(['user_id' => $id]);

        if($mensagens === null) {
            Yii::$app->response->statusCode = 404; // Define o status como 404
            return [
                'success' => false,
                'message' => 'O user não tem mensagens.',
            ];
        }

        Yii::$app->response->statusCode = 200; // Define o status como 200
        return [
            'success' => true,
            'mensagens' => $mensagens,
        ];

    }
}
