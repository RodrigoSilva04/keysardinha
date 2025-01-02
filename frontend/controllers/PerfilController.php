<?php

namespace frontend\controllers;

use common\models\User;
use Yii;
use common\models\Utilizadorperfil;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PerfilController extends Controller
{
    public function actionIndex()
    {
        // Obter o ID do utilizador logado
        $userId = Yii::$app->user->identity->id;

        // Encontrar o perfil e o utilizador
        $perfil = Utilizadorperfil::findOne($userId);
        $user = User::findOne($userId);

        if (!$perfil || !$user) {
            throw new NotFoundHttpException('Perfil ou utilizador não encontrado.');
        }

        return $this->render('index', [
            'perfil' => $perfil,
            'user' => $user,
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
        if (
            $perfil->load(Yii::$app->request->post()) &&
            $user->load(Yii::$app->request->post()) &&
            $perfil->save() &&
            $user->save()
        ) {
            Yii::$app->session->setFlash('success', 'Perfil atualizado com sucesso.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'perfil' => $perfil,
            'user' => $user,
        ]);
    }
}