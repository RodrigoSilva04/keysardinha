<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\User;
use common\models\Utilizadorperfil;
use Yii;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;


class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        Yii::$app->params['id'] = 0;
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
            'only'=> ['atualizar-user'], //Apenas para o GET
        ];
        return $behaviors;
    }

    public function actionLogin()
    {
        $data = json_decode(file_get_contents("php://input"), true); // Captura o JSON enviado

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

        $username = $user->username;

        // Retorna o token como resposta
        return [
            'status' => 'success',
            'message' => 'Login realizado com sucesso',
            'auth_key' => $user->auth_key,
            'username' => $username,
        ];
    }

    public function actionSignUp()
    {
        $data = json_decode(file_get_contents("php://input"), true); // Recebe as credenciais do usuário via POST

        // Verifica se as credenciais foram fornecidas
        if (empty($data['email']) || empty($data['password']) ||empty($data['username']) ) {
            throw new BadRequestHttpException('Email,senha e username são obrigatórios');
        }

        $user = new User();
        $user->username = $data['username'];  
        $user->email = $data['email'];        
        $user->setPassword($data['password']); // Define a senha
        $user->generateAuthKey(); // Gera a chave de autenticação
        $user->generateEmailVerificationToken(); // Gera o token de verificação de e-mail


        // Tenta salvar o utilizador
        if ($user->save()) {
            // Cria o perfil do usuário
            $utilizadorPerfil = new UtilizadorPerfil();
            $utilizadorPerfil->id = $user->id; // Associa o perfil ao ID do usuário
            $utilizadorPerfil->nome = null; // Nome será fornecido posteriormente
            $utilizadorPerfil->dataregisto = date('Y-m-d H:i:s'); // Data de registro
            $utilizadorPerfil->pontosacumulados = 0; // Inicia os pontos acumulados como 0
            $utilizadorPerfil->carrinho_id = null; // Define o carrinho como nulo, ou atribua um ID, se aplicável

            // Atribui a role de "client" ao usuário
            $auth = Yii::$app->authManager;
            $role = $auth->getRole('client'); // A role de "client" deve existir no RBAC
            if ($role) {
                $auth->assign($role, $user->id); // Atribui a role ao usuário
            } else {
                return Yii::$app->response->setStatusCode(400)->data = [
                    'status' => 'error',
                    'message' => 'Role "client" não encontrada.',
                ];
            }

            // Salva o perfil e envia o e-mail de verificação
            if ($utilizadorPerfil->save()) {
                return Yii::$app->response->setStatusCode(201)->data = [
                    'status' => 'success',
                    'message' => 'Utilizador criado com sucesso.',
                    'data' => [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'username' => $user->username,
                    ],
                ];
            } else {
                return Yii::$app->response->setStatusCode(400)->data = [
                    'status' => 'error',
                    'message' => 'Erro ao criar o utilizador.',
                    'errors' => $user->errors,  // Adicione erros específicos para identificar o campo com problema
                ];
            }
        }

        // Caso o utilizador não seja criado com sucesso
        return Yii::$app->response->setStatusCode(400)->data = [
            'status' => 'error',
            'message' => 'Erro ao criar o utilizador.',
            'errors' => $user->errors,
        ];
    }

    public function actionAtualizarUser()
{
    $usermodelID = Yii::$app->user->id; // Obtém o ID do usuário autenticado

    if (!$usermodelID) {
        throw new UnauthorizedHttpException('Usuário não autenticado.');
    }

    $userModel = User::findOne($usermodelID);
    $perfilModel = UtilizadorPerfil::findOne($usermodelID); // Buscar o perfil do usuário

    if (!$perfilModel) {
        throw new NotFoundHttpException('Perfil não encontrado.');
    }

    if (Yii::$app->request->isPut) {
        $data = json_decode(file_get_contents("php://input"), true);


        if (!isset($data['email']) && !isset($data['username'])) {
            throw new BadRequestHttpException(
                'Pelo menos o email ou username devem ser fornecidos. Dados recebidos: ' . print_r($data, true)
            );
        }

        // Atualiza os dados somente se forem enviados e diferentes do atual
        if (isset($data['email']) && $data['email'] !== $userModel->email) {
            if (User::find()->where(['email' => $data['email']])->andWhere(['!=', 'id', $userModel->id])->exists()) {
                throw new BadRequestHttpException('Este email já está em uso.');
            }
            $userModel->email = $data['email'];
        }

        if (isset($data['username'])) {
            $userModel = User::findOne($usermodelID);
            if (!$userModel) {
                throw new NotFoundHttpException('Usuário não encontrado.');
            }
            if ($data['username'] !== $userModel->username) {
                if (User::find()->where(['username' => $data['username']])->andWhere(['!=', 'id', $userModel->id])->exists()) {
                    throw new BadRequestHttpException('Este nome de utilizador já está em uso.');
                }
                $userModel->username = $data['username'];
            }
        }

        if ($userModel->save()) {
            return ['status' => 'success', 'message' => 'Perfil atualizado com sucesso.'];
        }
        if (!$user->save()) {
            throw new BadRequestHttpException('Erro ao atualizar perfil: ' . json_encode($user->errors, JSON_UNESCAPED_UNICODE));
        }
    

    }

    throw new BadRequestHttpException('Método inválido. Use PUT.');
}



    public function actionDelete($id)
    {
        $userModel = User::findOne($id);
        $perfilModel = UtilizadorPerfil::findOne($id);  // Buscar o perfil existente

        if ($userModel->delete() && $perfilModel->delete()) {
            return Yii::$app->response->setStatusCode(200)->data = [
                'status' => 'success',
                'message' => 'Perfil eliminado com sucesso.',
            ];
        }else{
            return Yii::$app->response->setStatusCode(400)->data = [
                'status' => 'error',
                'message' => 'Erro ao eliminar o perfil.',
                'errors' => $userModel->errors,
            ];
        }
    }
}