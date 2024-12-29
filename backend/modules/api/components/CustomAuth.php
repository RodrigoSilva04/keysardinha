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
            throw new ForbiddenHttpException('No authentication');
        }

        // Verifica a autenticidade do token
        $user = \common\models\User::findIdentityByAccessToken($authToken);
        if (!$user) {
            throw new ForbiddenHttpException('Invalid authentication token');
        }

        // Define o ID do usuário para uso posterior, se necessário
        Yii::$app->params['id'] = $user->id;

        return $user;
    }
}