<?php
namespace backend\modules\api\components;
use Yii;
use yii\filters\auth\AuthMethod;
use yii\web\ForbiddenHttpException;

class CustomAuth extends AuthMethod
{
    public function authenticate($user, $request, $response)
    {
        // Verifica o token da query string ou do cabeçalho "Authorization"
        $authToken = Yii::$app->request->get('access-token') ?: Yii::$app->request->headers->get('Authorization');

        // Se o token não foi encontrado, lança erro
        if (!$authToken) {
            $response->setStatusCode(401);
            throw new \yii\web\UnauthorizedHttpException('Token de autenticaçao nao fornecido.');
        }

        // Verifica a autenticidade do token
        $user = \common\models\User::findIdentityByAccessToken($authToken);
        if (!$user) {
            throw new \yii\web\UnauthorizedHttpException('Token de autenticaçao invalido');
        }

        // Define o ID do utilizador para uso posterior, se necessário
        Yii::$app->user->setIdentity($user);

        return $user;
    }
}