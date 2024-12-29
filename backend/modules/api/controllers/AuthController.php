<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\User;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;

class AuthController extends \yii\web\Controller
{

    public function actionLogin()
    {
        $data = Yii::$app->request->post(); // Recebe as credenciais do usuário via POST

        // Verifica se as credenciais foram fornecidas
        if (empty($data['email']) || empty($data['password'])) {
            throw new BadRequestHttpException('Email e senha são obrigatórios');
        }

        // Busca o usuário com base no e-mail
        $user = User::findOne(['email' => $data['email']]);

        if (!$user || !$user->validatePassword($data['password'])) {
            throw new ForbiddenHttpException('Credenciais inválidas');
        }

        // Gera um novo auth_key ou valida o existente
        if (!$user->auth_key) {
            $user->generateAuthKey(); // Gera um auth_key, se ainda não existir
            $user->save(); // Salva o auth_key no banco de dados
        }

        // Retorna o token como resposta
        return [
            'status' => 'success',
            'message' => 'Login realizado com sucesso',
            'auth_key' => $user->auth_key,
        ];
    }
}