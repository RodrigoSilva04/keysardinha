<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Favoritos;
use common\models\Utilizadorperfil;
use Yii;
use yii\rest\ActiveController;

class FavoritosController extends ActiveController
{
    public $modelClass = 'common\models\Favoritos';
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
            //only=> ['index'], //Apenas para o GET
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        $idUser = Yii::$app->user->id;

        if (!$idUser) {
            return Yii::$app->response->setStatusCode(401)
                ->data = [
                'status' => 'error',
                'message' => 'Usuário não autenticado.',
            ];
        }

        $favoritos = Favoritos::find()
            ->where(['utilizadorperfil_id' => $idUser])
            ->joinWith('produto') // Carregar dados dos produtos relacionados
            ->asArray()
            ->all();

        return Yii::$app->response->setStatusCode(200)
            ->data = [
            'status' => 'success',
            'message' => 'Favoritos recuperados com sucesso.',
            'data' => $favoritos,
        ];
    }


    // adicionar produto aos favoritos
    public function actionAdd()
    {
        // Receber o produto_id do corpo da requisição POST
        $produto_id = Yii::$app->request->post('produto_id');

        if (!$produto_id) {
            return [
                'status' => 'error',
                'message' => 'Produto não especificado.',
            ];
        }

        // Verificar se o produto já está nos favoritos do utilizador
        $favoritoExistente = Favoritos::find()
            ->where(['utilizadorperfil_id' => Yii::$app->user->id, 'produto_id' => $produto_id])
            ->one();

        if ($favoritoExistente) {
            // Produto já está nos favoritos
            Yii::$app->response->statusCode = 409;
            return [
                'status' => 'error',
                'message' => 'Produto já está nos favoritos.',
            ];
        }

        $favorito = new Favoritos();
        $favorito->utilizadorperfil_id = Yii::$app->user->id;
        $favorito->produto_id = $produto_id;

        // Tentar guardar o registo
        if ($favorito->save()) {
            Yii::$app->response->statusCode = 201;
            return [
                'status' => 'success',
                'message' => 'Produto adicionado aos favoritos com sucesso.',
            ];
        }

        // Caso ocorra um erro ao salvar o registo
        Yii::$app->response->statusCode = 500;
        return [
            'status' => 'error',
            'message' => 'Erro ao adicionar o produto aos favoritos.',
            'errors' => $favorito->errors,
        ];
    }

    // Remover produto dos favoritos
    public function actionRemove()
    {
        // Receber o produto_id do corpo da requisição
        $produto_id = Yii::$app->request->post('produto_id');

        if (!$produto_id) {
            return [
                'status' => 'error',
                'message' => 'Produto não especificado.',
            ];
        }

        // Encontra o registo nos favoritos baseado no user autenticado e no produto
        $produtofavorito = Favoritos::find()
            ->where(['utilizadorperfil_id' => Yii::$app->user->id, 'produto_id' => $produto_id])
            ->one();

        if ($produtofavorito) {
            // Remove o produto dos favoritos
            if ($produtofavorito->delete()) {
                Yii::$app->response->statusCode = 200;
                return [
                    'status' => 'success',
                    'message' => 'Produto removido dos favoritos com sucesso.',
                ];
            } else {
                Yii::$app->response->statusCode = 500;
                return [
                    'status' => 'error',
                    'message' => 'Erro ao remover o produto dos favoritos.',
                ];
            }
        }

        // Se nao for encontrado
        Yii::$app->response->statusCode = 404;
        return [
            'status' => 'error',
            'message' => 'Produto não encontrado nos favoritos.',
        ];
    }

    // Sincronizar favoritos offline
    public function actionOffline()
    {
        $utilizadorId = Yii::$app->user->id;

        // Verificar se o utilizador está autenticado
        if (!$utilizadorId) {
            Yii::$app->response->statusCode = 401; // Não autorizado
            return [
                'status' => 'error',
                'message' => 'Utilizador não autenticado.',
            ];
        }

        // Buscar os favoritos do utilizador
        $favoritos = Favoritos::find()
            ->where(['utilizadorperfil_id' => $utilizadorId])
            ->with('produto') // Carrega os detalhes do produto relacionado
            ->asArray()
            ->all();

        // Verificar se existem favoritos
        if (empty($favoritos)) {
            Yii::$app->response->statusCode = 404; // Não encontrado
            return [
                'status' => 'error',
                'message' => 'Nenhum favorito encontrado.',
            ];
        }

        // Retornar a lista de favoritos
        Yii::$app->response->statusCode = 200; // OK
        return [
            'status' => 'success',
            'message' => 'Favoritos sincronizados com sucesso.',
            'data' => $favoritos,
        ];
    }
}
