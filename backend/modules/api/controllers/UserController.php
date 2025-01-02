<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\User;
use common\models\Utilizadorperfil;
use Yii;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

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

    public function actionSignUp()
    {
        $data = Yii::$app->request->post(); // Recebe as credenciais do usuário via POST

        // Verifica se as credenciais foram fornecidas
        if (empty($data['email']) || empty($data['password'])) {
            throw new BadRequestHttpException('Email e senha são obrigatórios');
        }

        $user = new User();
        $user->username = $data->username;
        $user->email = $data->email;
        $user->setPassword($data->password); // Define a senha
        $user->generateAuthKey(); // Gera a chave de autenticação
        $user->generateEmailVerificationToken(); // Gera o token de verificação de e-mail

        // Tenta salvar o utilizador
        if ($user->save()) {
            // Cria o perfil do usuário
            $utilizadorPerfil = new UtilizadorPerfil();
            $utilizadorPerfil->user_id = $user->id; // Associa o perfil ao ID do usuário
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
            if ($utilizadorPerfil->save() && $this->sendEmail($user)) {
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
                    'message' => 'Erro ao criar o perfil ou enviar o e-mail de verificação.',
                    'errors' => $utilizadorPerfil->errors,
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

    public function actionUpdate($id)
    {
        $userModel = User::findOne($id);
        $perfilModel = UtilizadorPerfil::findOne($id);  // Buscar o perfil existente

        if ($this->request->isPost && $userModel->load($this->request->post())) {

            // Verificar se o campo de password não está vazio e, se sim, atualiza-a
            if (!empty($userModel->password)) {
                $userModel->setPassword($userModel->password);  // Definir a nova senha
            }

            if ($userModel->save()){
                // Atualizar o perfil
                $perfilModel->load($this->request->post());
                if ($perfilModel->save()) {
                    return Yii::$app->response->setStatusCode(200)->data = [
                        'status' => 'success',
                        'message' => 'Perfil atualizado com sucesso.',
                    ];
                }else{
                    return Yii::$app->response->setStatusCode(400)->data = [
                        'status' => 'error',
                        'message' => 'Erro ao atualizar o perfilutilizador.',
                        'errors' => $perfilModel->errors,
                    ];
                }
            }else{
                return Yii::$app->response->setStatusCode(400)->data = [
                    'status' => 'error',
                    'message' => 'Erro ao atualizar o perfil.',
                    'errors' => $userModel->errors,
                ];
            }
        }

        return Yii::$app->response->setStatusCode(400)->data = [
            'status' => 'error',
            'message' => 'Erro ao atualizar o perfil. Post não enviado.',
            'errors' => $userModel->errors,
        ];
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