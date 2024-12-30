<?php

namespace backend\modules\api\controllers;


use backend\modules\api\components\CustomAuth;
use yii\filters\auth\QueryParamAuth;
use common\models\Favoritos;
use common\models\Utilizadorperfil;
use Yii;
use yii\rest\ActiveController;

class FavoritosController extends ActiveController
{


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
            //only=> ['index'], //Apenas para o GET
        ];
        return $behaviors;
    }

    public $modelClass = 'common\models\Favoritos';

    public function actionIndex()
    {
        // Obter o ID do utilizador autenticado
        $idUser = Yii::$app->user->id;

        // Verificar se o utilizador está autenticado
        if (!$idUser) {
            return Yii::$app->response->setStatusCode(401) // Não autorizado
            ->data = [
                'status' => 'error',
                'message' => 'Usuário não autenticado.',
            ];
        }

        // Obter o perfil do utilizador
        $user = UtilizadorPerfil::findOne($idUser);

        // Verificar se o perfil do utilizador foi encontrado
        if (!$user) {
            return Yii::$app->response->setStatusCode(404) // Não encontrado
            ->data = [
                'status' => 'error',
                'message' => 'Perfil do usuário não encontrado.',
            ];
        }

        // Obter os favoritos do utilizador
        $favoritos = $user->getFavoritos()->all();

        // Retornar os favoritos em resposta
        return Yii::$app->response->setStatusCode(200) // OK
        ->data = [
            'status' => 'success',
            'message' => 'Favoritos recuperados com sucesso.',
            'data' => $favoritos,
        ];
    }

    // adicionar produto aos favoritos
    public function actionAdd($produto_id)
    {
        // Verificar se o produto já está nos favoritos do utilizador
        $favoritoExistente = Favoritos::find()
            ->where(['utilizadorperfil_id' => Yii::$app->user->id, 'produto_id' => $produto_id])
            ->one();

        if ($favoritoExistente) {
            // Produto já está nos favoritos
            Yii::$app->response->statusCode = 409; // Código de conflito
            return [
                'status' => 'error',
                'message' => 'Produto já está nos favoritos.',
            ];
        }

        // Criar um novo registo de favorito
        $favorito = new Favoritos();
        $favorito->utilizadorperfil_id = Yii::$app->user->id;
        $favorito->produto_id = $produto_id;

        // Tentar salvar o registro
        if ($favorito->save()) {
            Yii::$app->response->statusCode = 201; // Código de sucesso (criado)
            return [
                'status' => 'success',
                'message' => 'Produto adicionado aos favoritos com sucesso.',
            ];
        }

        // Caso ocorra um erro ao salvar o registo
        Yii::$app->response->statusCode = 500; // Código de erro interno
        return [
            'status' => 'error',
            'message' => 'Erro ao adicionar o produto aos favoritos.',
            'errors' => $favorito->errors,
        ];
    }

    // Remover produto dos favoritos
    public function actionRemove($produto_id)
    {
        // Busca o registo nos favoritos baseado no user autenticado e no produto
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

        // Caso o produto não seja encontrado nos favoritos
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
